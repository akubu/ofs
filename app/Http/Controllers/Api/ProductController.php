<?php
/**
 * File contains controller class to handle api requests for products
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
use Illuminate\Http\Request;
use App\Classes\Curl;
use Session;
use App\Models\ProductLineSKU as PLS;
use App\Models\Product;
use Redis;

/**
 * Controller class to handle api requests for products
 *
 * @extends  Controller
 * @category Api
 * @package  Product
 * @author   Abani Meher <abani.meher@power2sme.com>
 * @license  
 * @link     
 */
class ProductController extends Controller
{
    /**
     * Create a new product API instance.
     *
     * @return void
     */
    public function __construct()
    {

    }
    
    /**
     * Retrieves product details from CS Cart
     *
     * @param object $request - current request object
     * 
     * @return object
     */
    public function get(Request $request, $id = false) 
    {
		//get product search query
		$query = http_build_query($request->all());
		
		Curl::init(config('cscart.api.url.products') . '?' . $query . '&status=A&sort_by=id&sort_order=desc');
		$result = Curl::get();
		$result['url'] = config('cscart.api.url.products') . '?' . $query . '&status=A&sort_by=id&sort_order=desc';		
        return response()->json($result);
    }
    
    /**
     * Sends data to CS cart to save product details
     *
     * @param object $request - current request object
     * 
     * @return oblect
     */
    public function save(Request $request) 
    {
        //get data from request
        $data = $request->all();

		//check if product exists
		
        Curl::init(config('cscart.api.url.products') . '?q=' . urlencode($data['product'])  . '&sort_by=id&sort_order=desc');
        $result = Curl::get();
		
		foreach($result['data']->products as $product) {
			if($product->product === $data['product']) {
				$result['error'] = true;
				$result['message'] = 'Product <b>' . $data['product'] . '</b> already exists.';
				
				return response()->json($result);
			}
		}
		
		//get last SKU
        Curl::init(config('cscart.api.url.products') . '?pcode=SKUN&sort_by=id&sort_order=desc');
        $result = Curl::get();
        
		$product = $result['data']->products[0];
		$last_sku = str_replace('SKUN','', strtoupper($product->product_code));
		$new_sku = 'SKUN' . ($last_sku + 1);

        $data['category_ids'] = array($data['categories']);
        $data['product_code'] = $new_sku;
        $data['company_id'] = 104;
        $data['price'] = 1;
        $data['status'] = 'A';
        $data['short_description'] = Session::get('vt_user', -1);
        $data['product'] = strip_tags($data['product']);
		
        //initiate curl
        Curl::init(config('cscart.api.url.products'));
        
        //post data and get result
        $result = Curl::post($data);

        //if there is no error in saving data, save product features
        if (!$result['error']) {
            
            //update features
            Curl::init(config('cscart.api.url.products') . $result['data']->product_id);
            $result = Curl::put($data);
            
			//send SKU in response
			$result['sku'] = $new_sku;
			$result['product_name'] = $data['product'];
			
			//insert data in product line SKU
			try {
				$pline_sku = new PLS();
				$pline_sku->Product_code = $new_sku; 
				$pline_sku->PL = '0';
				$pline_sku->save();
			} catch(Exception $exception) {
				
				$response['error'] = true;
				$response['message'] = 'Error occured while saving data - ERR_PLINE_SKU';
				$response['source'] = 'DB';
				$result['pline_sku'] = $response;
			}

			try {
				//save product info in database to push it to Navision using cron
				$product = new Product();
				$product->name = $data['product'];
				$product->cscart_product_id = $result['data']->product_id;
				$product->sku = $new_sku;
				$product->category_id = $data['categories'];
				$product->company_id = $data['company_id'];
				$product->price = $data['price'];
				$product->created_by = Session::get('vt_user');
				$product->pushed_to_navision = 0;
				$product->save();
			} catch(Exception $exception) {
				
				$response['error'] = true;
				$response['message'] = 'Error occured while saving data - ERR_LCL_SAVE';
				$response['source'] = 'DB';
				$result['lcl_save'] = $response;
			}
        }
        
        
        return response()->json($result);
    }
    
    /**
     * Sends new SKU to external  APIs
     *
     * @param string $sku - newly created SKU
     * 
     * @return array
     */
	protected function callExternalService($sku) 
	{
		
		//insert data in product line SKU
		try {
			$pline_sku = new PLS();
			$pline_sku->Product_code = $sku; 
			$pline_sku->PL = '0';
			$pline_sku->save();
		} catch(Exception $exception) {
			
			$response['error'] = true;
			$response['message'] = 'Error occured while saving data - ERR_PLINE_SKU';
			$response['source'] = 'DB';
			return $response;
		}
		
		//if calling external api is disabled, return
		if(!config('cscart.call_external_api')) {
			$response['error'] = false;
			$response['source'] = 'PLS';
			return $response;
		}
		
		//send success response
		$response['error'] = false;
		$response['message'] = 'Updated successfully';
		return  $response;
	}
}
