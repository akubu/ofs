<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Permission;
use App\Models\UserPermissions;
class AccessControlController extends Controller
{
    /**
     * Shows access control page
     *
     * @return object
     */
    public function index() 
    {
		$this->data['permissions'] = Permission::all();
		$this->data['user_permissions'] = 1;
		return view('auth.access_control', $this->data);
	}

    /**
     * Shows access control page
     *
     * @return object
     */
    public function save(Request $request) 
    {
		$data = $request->all();
		
		//filter unnecessary keys
		
		$validator = Validator::make($data['user'], [
            'vtiger_user_id' => 'required|unique:users,vtiger_user_id|max:10|min:5',
            'name' => 'required',
        ]);
		
		//if validation fails, get all error messages and send it in response
		if ($validator->fails()) {
			
			$messages = $validator->errors()->toArray();
			$response['error'] = true;
			$response['message']  = $messages;
        } else {
			
			//if user_token is set and valid, update user request, else create user request
			if(!empty($data['user_token']) && Session::has($data['user_token']) && 
				is_numeric(Session::get('user_token'))) {
					
				User::where('id', Session::get('user_token'))
					->update($data['user']);
			} else {
				
				$data['user']['created_at'] =  date('Y-m-d H:i:s');
				$data['user']['created_by'] =  Session::get('vt_user');
				$data['user']['is_active'] =  '1';
				$data['user']['is_actisve'] =  '1';
				
				try {
					$response['error'] = !User::insert($data['user']);
				} catch(QueryException $exception) {
					echo $exception->getMessage();
				}
			}
			
		}
		return response()->json($response);
	}
	
	
}
