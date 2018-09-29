<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Company;
use App\Models\LeadAssignment;
use App\Models\StatusUpdate;
use App\Models\Payment;
use Carbon\Carbon;

class ClientController extends Controller
{
    // Create company 
    public function createClient(Request $request){
    	try{
    		    $inputs = $request->all();
			
            $validator = ( new Client )->ValidateClientApp( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }
            $status_type = $inputs['status'];
            $user_id = \Auth::User()->id;
            $company_id = Company::where('status', 1)->value('id');
            $inputs = $inputs + [
                                  'user_id' => $user_id,
                                  'company_id' => $company_id,
                                  ];

            if (isset($inputs['alt_contact'])) {
                $inputs = $inputs + [
                                  'alt_contact' => $inputs['alt_contact'],
                                  ];
            }
            if (isset($inputs['anni_date'])) {
                $inputs = $inputs + [
                                  'anni_date' => $inputs['anni_date'],
                  ];
            }
            
            $client_id = (new Client)->store($inputs);

            $user_type = \Auth::User()->user_type;
            $inputs = $inputs + [
                                  'client_id' => $client_id,
                                  'user_type' => $user_type,
                                  'w_e_f' => Carbon::now(),
                                  'status' => 1,
                  ];
            (new LeadAssignment)->store($inputs);

            $inputs = $inputs + [
                                  'status_type' => $status_type,
                  ];

            (new StatusUpdate)->store($inputs);

            if ($status_type ==  3) {
              $inputs = $inputs + [
                                  'offered_price' => $inputs['product_price'],
                                  'recieved_amount' => 0,
                                  'discount' => 0,
                                  'out_amount' => 0,
                  ];
            }
            (new Payment)->store($inputs);
            return apiResponseApp(true, 200, lang('Clinet created successfully'));


    	}catch(Exception $e){
			return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }

   //   // Create company 
   //  public function editClient(Request $request){
   //  	try{
   //  		  $inputs = $request->all();
      
   //          $validator = ( new Client )->ValidateClientAppUpdate( $inputs );
   //          if( $validator->fails() ) {
   //              return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
   //          }
   //          $status_type = $inputs['status'];
   //          $user_id = \Auth::User()->id;
   //          $company_id = Company::where('status', 1)->value('id');
   //          $inputs = $inputs + [
   //                                'user_id' => $user_id,
   //                                'company_id' => $company_id,
   //                                ];

   //          if (isset($inputs['alt_contact'])) {
   //              $inputs = $inputs + [
   //                                'alt_contact' => $inputs['alt_contact'],
   //                                ];
   //          }
   //          if (isset($inputs['anni_date'])) {
   //              $inputs = $inputs + [
   //                                'anni_date' => $inputs['anni_date'],
   //                ];
   //          }
            
   //          $client_id = (new Client)->store($inputs);

   //          $user_type = \Auth::User()->user_type;
   //          $inputs = $inputs + [
   //                                'client_id' => $client_id,
   //                                'user_type' => $user_type,
   //                                'w_e_f' => Carbon::now(),
   //                                'status' => 1,
   //                ];
   //          (new LeadAssignment)->store($inputs);

   //          $inputs = $inputs + [
   //                                'status_type' => $status_type,
   //                ];

   //          (new StatusUpdate)->store($inputs);

   //          if ($status_type ==  3) {
   //            $inputs = $inputs + [
   //                                'offered_price' => $inputs['product_price'],
   //                                'recieved_amount' => 0,
   //                                'discount' => 0,
   //                                'out_amount' => 0,
   //                ];
   //          }
   //          return apiResponseApp(true, 200, lang('Client updated successfully'));



   //  	}catch(Exception $e){
			// return apiResponseApp(false, 500, lang('messages.server_error'));
   //  	}
   //  }

   //   //Delete Company
   //  public function deleteCompany(Request $request){
   //      try{
   //          $inputs = $request->all();
            
   //          $validator = ( new Company )->validateCompanyEdit( $inputs );
   //          if( $validator->fails() ) {
   //              return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
   //          }
   //          $id = $inputs['id'];
   //          $inputs['status'] = 0;
   //          $user_profile = (new Company)->deleteAccount($id);
   //          return apiResponseApp(true, 200, 'Company record successfully deleted');


   //      }catch(Exception $e){
   //          return apiResponseApp(false, 500, lang('messages.server_error'));
   //      }
   //  }

     //Client List
    public function clientList(){
        try{            
            $client = Client::get();
            if (count($client) != 0) {
              return apiResponseApp(true, 200, null, [], $client);
            }else{
              return apiResponseApp(false, 400, lang('No Client record found'));
            }


        }catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }
}
