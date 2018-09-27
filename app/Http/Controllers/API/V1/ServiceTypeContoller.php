<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ServiceType;

class ServiceTypeContoller extends Controller
{
    //Create service Type
    public function createServiceType(Request $request){
    	try{
    		$inputs = $request->all();
			
			$validator = ( new ServiceType )->validateServiceType( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }

            $name = $inputs['service_type'];
            $check = (new ServiceType)->where('service_type', '=', $name)->first();

            if (count($check) >= 1) {
                $message = array('Service Type' => 'Service Type already exist in our records');
                return apiResponseApp(false, 406, "",  $message);
            }

            $id = (new ServiceType)->store($inputs);
            return apiResponseApp(true, 200, lang('Service Type created successfully'));


    	}catch(Exception $e){
			return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }

    //Create service Type
    public function editServiceType(Request $request){
    	try{
    		$inputs = $request->all();
			
			$validator = ( new ServiceType )->validateServiceTypeEdit( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }

            $id = $inputs['id'];
            $name = $inputs['service_type'];
            $check = (new ServiceType)->where('service_type', '=', $name)->where('id', '!=', $id)->first();

            if (count($check) >= 1) {
                $message = array('Service Type' => 'Service Type already exist in our records');
                return apiResponseApp(false, 406, "",  $message);
            }

            $id = (new ServiceType)->store($inputs, $id);
            return apiResponseApp(true, 200, lang('Service Type updated successfully'));


    	}catch(Exception $e){
			return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }

      //Service List
    public function serviceList(){
        try{
            
            $service = ServiceType::get();
            if (count($service) != 0) {
                return apiResponseApp(true, 200, null, [], $service);
            }else{
                return apiResponseApp(false, 400, 'No services found');
            }


        }catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }

     //Delete Company
    public function deleteService(Request $request){
        try{
            $inputs = $request->all();
            
            $validator = ( new ServiceType )->validateServiceTypeDelete( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }

            $id = $inputs['id'];
            $inputs['status'] = 0;
            $user_profile = (new ServiceType)->deleteAccount($id);
            return apiResponseApp(true, 200, 'Service Type record successfully deleted');


        }catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }
}
