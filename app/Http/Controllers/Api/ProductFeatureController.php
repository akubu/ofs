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
class ProductFeatureController extends Controller
{
    /**
     * Create a new product features API instance.
     *
     * @return void
     */
    public function __construct()
    {

    }
}
