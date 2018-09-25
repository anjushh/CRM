<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
   //  //Create service 
   //  public function createService(Request $request){
   //  	try{
   //  		$inputs = $request->all();
			
			// $validator = ( new Service )->validateServiceType( $inputs );
   //          if( $validator->fails() ) {
   //              return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
   //          }

   //          $name = $inputs['service_type'];
   //          $check = (new ServiceType)->where('service_type', '=', $name)->first();

   //          if (count($check) >= 1) {
   //              $message = array('Service Type' => 'Service Type already exist in our records');
   //              return apiResponseApp(false, 406, "",  $message);
   //          }

   //          $id = (new ServiceType)->store($inputs);
   //          return apiResponseApp(true, 200, lang('Service Type created successfully'));


   //  	}catch(Exception $e){
			// return apiResponseApp(false, 500, lang('messages.server_error'));
   //  	}
   //  }
}
