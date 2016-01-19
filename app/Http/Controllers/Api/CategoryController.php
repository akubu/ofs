<?php
/**
 * File contains controller class to handle api requests for categories
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

/**
 * Controller class to handle api requests for categories
 *
 * @extends  Controller
 * @category Api
 * @package  Category
 * @author   Abani Meher <abani.meher@power2sme.com>
 * @license  
 * @link     
 */
class CategoryController extends Controller
{
    /**
     * Create a new category API instance.
     *
     * @return void
     */
    public function __construct()
    {
		parent::__construct();
    }
    
    /**
     * Retrieves categories from CS Cart
     *
     * @param int $id - category id(optional)
     * 
     * @return array
     */
    public function get($id = false)
    {
		Curl::init(config('cscart.api.url.categories') . $id);
		$result = Curl::get();

		return response()->json($result);
	}
}
