<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Company;
use App\Models\ServiceType;

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
                'company_id' => $company,
            ];
            $inputs = $inputs + ['status' => 1];
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

    //Delete service 
    public function allService(){
      try{
         
          $data = Service::get();
          if (count($data) != 0) {
            foreach ($data as $datas) {
              $datas['service_type_name'] = ServiceType::where('id', $datas->service_type)->value('service_type');
              $datas['company_name'] = Company::where('id', $datas->company_id)->value('company_name');
              $datas['parent_name'] = Service::where('id', $datas->parent_id)->value('service_name');
            }
            return apiResponseApp(true, 200, null, [], $data);
          }else{
            return apiResponseApp(false, 400, 'No records found for services');
          }


      }catch(Exception $e){
         return apiResponseApp(false, 500, lang('messages.server_error'));
      }
    }

    //All service  with status 1
    public function allServiceUpdated(){
      try{
         
          $data = Service::where('status', 1)->get();
          if (count($data) != 0) {
            foreach ($data as $datas) {
              $datas['service_type_name'] = ServiceType::where('id', $datas->service_type)->value('service_type');
              $datas['company_name'] = Company::where('id', $datas->company_id)->value('company_name');
              $datas['parent_name'] = ServiceType::where('id', $datas->parent_id)->value('service_type');
            }
            return apiResponseApp(true, 200, null, [], $data);
          }else{
            return apiResponseApp(false, 400, 'No records found for services');
          }


      }catch(Exception $e){
         return apiResponseApp(false, 500, lang('messages.server_error'));
      }
    }
}
