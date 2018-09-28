<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;
use App\Company;

class ServiceController extends Controller
{
    //Create service 
    public function createService(Request $request){
    	try{
    		$inputs = $request->all();
			
			$validator = ( new Service )->validateService( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }

            $company = Company::where('status', 1)->value('id');
            $inputs = $inputs + [
                        'company_id' => 1
               ];
            $id = (new Service)->store($inputs);
            return apiResponseApp(true, 200, lang('Service created successfully'));


    	}catch(Exception $e){
			return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }

    //Edit service 
    public function editService(Request $request){
      try{
         $inputs = $request->all();
         
         $validator = ( new Service )->validateServiceEdit( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }

            $company = Company::where('status', 1)->value('id');
            $inputs = $inputs + [
                        'company_id' => 1
               ];
            $id = (new Service)->store($inputs, $inputs['id']);
            return apiResponseApp(true, 200, lang('Service updated successfully'));


      }catch(Exception $e){
         return apiResponseApp(false, 500, lang('messages.server_error'));
      }
    }


    //Delete service 
    public function deleteService(Request $request){
      try{
         $inputs = $request->all();
         
         $validator = ( new Service )->validateServiceEdit( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }

         
            $id = (new Service)->deleteAccount($inputs, $inputs['id']);
            return apiResponseApp(true, 200, lang('Service deleted successfully'));


      }catch(Exception $e){
         return apiResponseApp(false, 500, lang('messages.server_error'));
      }
    }
}
