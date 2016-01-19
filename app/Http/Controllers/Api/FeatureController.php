<?php
/**
 * File contains controller class to handle api requests for product features
 *
 * @category Controller
 * @package  Api
 * @author   Abani Meher <abani.meher@power2sme.com>
 * @license  
 * @link     
 */
namespace App\Http\Controllers\Api;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use App\Classes\Curl;
use Illuminate\Http\Request;
use Redis;

/**
 * Controller class to handle api requests for product features
 *
 * @extends  Controller
 * @category Api
 * @package  ProductFeature
 * @author   Abani Meher <abani.meher@power2sme.com>
 * @license  
 * @link     
 */
class FeatureController extends Controller
{
    /**
     * Create a new product features API instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Retrieves features from CS Cart
     *
     * @param int $id - category id(optional)
     * 
     * @return object
     */
    public function get(Request $request, $id = false, $force_api = false)
    {
		//connect to redis
		$redis = Redis::Connection();
		
		//if feature detail is in memory, pull from memory
		if($redis->hExists('features', $id === false ? 0 : $id) && !$force_api) {

			$result['error'] = false;
			$result['from'] = 'MEMORY';
			$result['data'] = json_decode($redis->hGet('features', $id === false ? 0 : $id));
		} else {
			
			Curl::init(config('cscart.api.url.features') . $id);
			$result = Curl::get();
			$result['from'] = 'API';
			
			if($id !== false) {
				
				$result['data']->variants_count = count((array)$result['data']->variants);
			}

			//save data in redis for future use
			Redis::hset('features', $id === false ? 0 : $id, json_encode($result['data']));
		}
		
		//set next index to fetch
		$result['next_index'] = (int) $request->get('index') + 1;
		
		return response()->json($result);
	}

    /**
     * Saves feature variant in CS Cart
     *
     * @param int $id - feature id(optional)
     * 
     * @return object
     */
    public function save_variant(Request $request)
    {
		$feature_id = $request->get('feature_id');
		$variants[]['variant'] = htmlentities($request->get('new_variant'));

		$data = array(
					'variants' => $variants,
					'feature_type' => $request->get('feature_type'),
					'original_var_ids' => ''
				);
		Curl::init(config('cscart.api.url.features') . $feature_id);
		$result = Curl::put($data);
		
		return response()->json($result);
	}
}
