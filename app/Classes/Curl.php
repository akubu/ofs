<?php
/**
 * File contains class to handle curl request
 *
 * @category Class
 * @package  Curl
 * @author   Abani Meher <abani.meher@power2sme.com>
 * @license  
 * @link     
 */

namespace App\Classes;

/**
 * Class to handle curl request
 *
 * @category Class
 * @package  Curl
 * @author   Abani Meher <abani.meher@power2sme.com>
 * @license  
 * @link     
 */
class Curl
{
    /**
     * Handle to store the curl resource
     * 
     * @var    resource(of type  curl)
     * @access private
     */
    private static $_curl_handle;
    
    /**
     * Response received from server
     * 
     * @var    array
     * @access private
     */
    private static $_response;
    
    /**
     * Namespace to use for configs
     * 
     * @var    string
     * @access private
     */
    private static $_namespace;
    
    /**
     * HTTP header codes to retrieve after making request
     * 
     * @var    array
     * @access private
     */
    private static $_collect_response_headers;

    /**
     * PHP magic method to set curl options
     *
     * @param string $method_name - called method which does not exists in class
     * @param array  $args        - arguments passed to the non-existant method
     *
     * @return void
     */
    public static function __callStatic($method_name, $args)
    {
        if (defined('CURLOPT' . strtoupper($method_name))) {
            
            $option = constant('CURLOPT' . strtoupper($method_name));
            curl_setopt(static::$_curl_handle, $option, $args[0]);
        }
    }

    /**
     * Sets namespace from which config details will be read
     *
     * @param string $namespace - config file name from which configuration will be read
     *
     * @return void
     */
    public static function setNameSpace($namespace)
    {
		static::$_namespace = $namespace;
	}

    /**
     * Sets http header response to receive after making request
     *
     * @param string/array $headers - headers value to be retrieved after request
     *
     * @return void
     */
    public static function collectResponseHeaders()
    {
		static::$_collect_response_headers = true;
		static::header(1);
	}
    

    /**
     * Initialize the curl request and sets required details
     *
     * @param string $url - url to which curl request is made
     *
     * @return void
     */
    public static function init($url, $replace = array())
    {
		//if url is empty, throw exception
		if(is_null($url)) {
			
			throw new Exception('URL is empty. Provide URL to which request will be sent.');
		}
		
		//if url has a dynamic parameter, replace it
		if (!empty($replace)) {
			
			$url = str_replace(array_keys($replace), array_values($replace), $url);
		}

        //initialize curl
        static::$_curl_handle = curl_init();
        
        //if namespace is not set, set it to cscart by default
        if(empty(static::$_namespace)) {
			static::$_namespace = 'cscart';
		}
        
        //set required options
        if(substr($url, 0, 1) == '/') {
			static::_url(config(static::$_namespace . '.api.' . config('app.env') . '.hostname') . $url);
		} else {
			static::_url($url);
		}

		static::_userpwd(config(static::$_namespace . '.api.' . config('app.env') . '.auth'));
        static::_returnTransfer(true);
        static::_httpheader(array('Content-Type: text/plain'));
		static::$_collect_response_headers = false;
    }
    
    /**
     * Sends the curl request to the server
     *
     * @return array
     */
    private static function _send()
    {
		//check if init has not been done
		if(is_null(static::$_curl_handle)) {
			
			static::$_response['error'] = true;
			static::$_response['message'] = 'Call Curl::init() method before making a request.';
			
			return static::$_response;
		}
		
        //execute the curl request
        static::$_response['data'] = curl_exec(static::$_curl_handle);

		if(static::$_response['data'] !== false) {
			
			//decode response to see if there is any error
			static::$_response['data'] = json_decode(static::$_response['data']);
		}
		
        //in case of error, find out error details and set in response
        if (static::$_response['data'] === false) {
            
            static::$_response['error'] = true;
            static::$_response['errno'] = curl_errno(static::$_curl_handle);
            static::$_response['message'] = curl_error(static::$_curl_handle);
            static::$_response['source'] = 'CURL';
        } elseif (is_object(static::$_response['data']) && 
					property_exists(static::$_response['data'], 'status') && 
					is_numeric(static::$_response['data']->status)) {

            static::$_response['error'] = true;
            static::$_response['errno'] = static::$_response['data']->status;
            static::$_response['message'] = static::$_response['data']->message;
            static::$_response['source'] = 'API';
        } else {
			
            static::$_response['error'] = false;
        }
		
		//if response headers is required, send it
		if(static::$_collect_response_headers) {
			static::$_response['headers'] = curl_getinfo(static::$_curl_handle);
		}
        
        //close the curl handle
        curl_close(static::$_curl_handle);
        
        //return the response
        return static::$_response;
    }
    
    /**
     * Makes a GET request to the specified url
     *
     * @param array $data - data to send as query string
     * 
     * @return array
     */
    public static function get(array $data = array())
    {
        return static::_send();
    }
    
    /**
     * Makes a POST request to the specified url
     *
     * @param array $data - data to send in the request
     * 
     * @return array
     */
    public static function post(array $data = array())
    {
        //set request type to POST and set post fields
        static::_post(true);
        static::_postFields(http_build_query($data));

        return static::_send();
    }
    
    /**
     * Makes a PUT request to the specified url
     *
     * @param array $data - data to send in the request
     * 
     * @return array
     */
    public static function put(array $data = array())
    {
        //set request type to PUT and set post fields
        static::_customRequest('PUT');
        static::_postFields(http_build_query($data));
        
        return static::_send();
    }
    
    /**
     * Makes a DELETE request to the specified url
     *
     * @param array $data - data to send in the request
     * 
     * @return array
     */
    public static function delete(array $data = array())
    {
        //set request type to DELETE
        static::_customRequest('DELETE');
        
        return static::_send();
    }
}
