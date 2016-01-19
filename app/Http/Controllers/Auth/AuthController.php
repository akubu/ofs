<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Session;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    
    /**
     * Shows login page
     *
     * @return object
     */
    public function login() 
    {
		return view('auth.login' );//, $this->data);
	}
	
    /**
     * Logs a user out of the session
     *
     * @return object
     */
    public function logout() 
    {
		//remove details from laravel session
		Session::forget('authenticated');
		Session::forget('vt_user');
		
		//remove details from PHP native session
		session_start();
		unset($_SESSION['authenticated']);
		
		//redirect user to login page
		return redirect('auth/login')->with('message', 'Logged out successfully.');
	}
	
    /**
     * Validates user login from vtiger database using API
     *
     * @param Object $request - current request object
     * 
     * @return object
     */
	public function validateVtigerUser(Request $request) 
	{
		//create user validation link
		$url = "http://uat.power2sme.com/p2sapi/ws/v3/userlogin";

		$data = array('userId' => $request->input('username'), 
			'password' => $request->input('password'));


		//make curl request to validate user
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERPWD, 'website:p2sWebs!te');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen(json_encode($data)))                                                                       
		); 
		$result = json_decode(curl_exec ($ch));

		//if login id and password combination is corrent, allow login
		if($result->ErrorCode == 0) {

			//dd($result);
			//put details in laravel session
            session_start();
            $_SESSION['vt_user'] = $request->input('username');
			Session::put('authenticated', true);
			Session::put('vt_user', $request->input('username'));
			$name = $result->Data->employee->firstName .' '. $result->Data->employee->lastName;

			Session::put('vt_user_name', $name ); // +' ' + $request->input('lastname'));


			//hack for deals codebase

			$response = array();
			$response['error'] = false;
			$response['redirect'] = '/';
		} else {

			Session::put('authenticated', false);


			$response = array();
			$response['error'] = true;
			$response['message'] = 'Please use valid login username and password.';
		}

		return response()->json($response);
	}
}
