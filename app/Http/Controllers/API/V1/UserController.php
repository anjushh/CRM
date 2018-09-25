<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserLogin;
use App\UserType;

class UserController extends Controller
{
    //Create User
    public function create(Request $request){
    	try{
    		$inputs = $request->all();
			
			$validator = ( new UserLogin )->validateUser( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }

            $email = $inputs['email'];
            $check = (new UserLogin)->where('email', '=', $email)->first();

            if (count($check) >= 1) {
                $message = array('email' => 'Email already exist in our records');
                return apiResponseApp(false, 406, "",  $message);
            }

            if (isset($inputs['mobile'])) {
            	$phone = $inputs['mobile'];
            	$check_mobile = (new UserLogin)->where('mobile', '=', $phone)->first();

	            if (count($check_mobile) >= 1) {
	                $message = array('mobile' => 'Mobile number already exist in our records');
	                return apiResponseApp(false, 406, "",  $message);
	            }
            }
			$password = \Hash::make($inputs['password']);
			unset($inputs['password']);
            $inputs = $inputs + ['password' => $password];

            $id = (new UserLogin)->store($inputs);
            return apiResponseApp(true, 200, lang('User created successfully'));


    	}catch(Exception $e){
			return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }

    //Create User
    public function userType(Request $request){
    	try{
    
    		$user_type = UserType::get();
            return apiResponseApp(true, 200, null, [], $user_type);


    	}catch(Exception $e){
			return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }

    //User Profile
    public function userProfile(){
        try{
    
            $user_profile = UserLogin::where('id', \Auth::User()->id)->get();
            return apiResponseApp(true, 200, null, [], $user_profile);


        }catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }

    //Edit Profile
    public function editProfile(Request $request){
        try{
            $inputs = $request->all();
            
            $validator = ( new UserLogin )->validateUserEdit( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }

            $user_id = $inputs['user_id'];
            if (isset($inputs['email'])) {
               $email = $inputs['email'];
                $check = (new UserLogin)->where('email', '=', $email)->where('id', '!=', $user_id)->first();

                if (count($check) >= 1) {
                    $message = array('email' => 'Email already exist in our records');
                    return apiResponseApp(false, 406, "",  $message);
                }
            }
            

            if (isset($inputs['mobile'])) {
                $phone = $inputs['mobile'];
                $check_mobile = (new UserLogin)->where('mobile', '=', $phone)->where('id', '!=', $user_id)->first();

                if (count($check_mobile) >= 1) {
                    $message = array('mobile' => 'Mobile number already exist in our records');
                    return apiResponseApp(false, 406, "",  $message);
                }
            }

            if (isset($inputs['password'])) {
                $password = \Hash::make($inputs['password']);
                unset($inputs['password']);
                $inputs = $inputs + ['password' => $password];
            }

            $user_profile = (new UserLogin)->store($inputs, $user_id);
            $user = UserLogin::where('id', $user_id)->get();
            return apiResponseApp(true, 200, null, [], $user);
        }catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }

    //User Profile
    public function deleteUser(Request $request){
        try{
            $inputs = $request->all();
            
            $validator = ( new UserLogin )->validateUserDelete( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }
            $user_id = $inputs['user_id'];
            $inputs['status'] = 0;
            $user_profile = (new UserLogin)->deleteAccount($user_id);
            return apiResponseApp(true, 200, 'User record successfully deleted');


        }catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }
}
