<?php
/**
 * File contains controller class to handle notifications
 *
 * @category Controller
 * @package  Notification
 * @author   Abani Meher <abani.meher@power2sme.com>
 * @license  
 * @link     
 */
namespace App\Http\Controllers\Notification;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Redis;

/**
 * Controller class to handle notifications
 *
 * @extends  Controller
 * @category Controller
 * @package  Product
 * @author   Abani Meher <abani.meher@power2sme.com>
 * @license  
 * @link     
 */
class NotificationController extends Controller
{
    /**
     * Create a new product controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		parent::__construct();
    }
	
    /**
     * returns product status related  notification
     *
     * @return object
     */
	public function get()
	{
		$redis = Redis::connection();
		
		//pull notification from redis
		if($redis->hExists('notification', Session::get('vt_user'))) {
			$response['notification'] = json_decode($redis->hGet('notification', Session::get('vt_user')));
		} else {
			$response['notification'] = array();;
		}
		
		$response['count'] = count($response['notification']);
		
		//delete from Redis
		$redis->hDel('notification', Session::get('vt_user'));
		
		return response()->json($response);
	}
}
