<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Company;
use App\Models\LeadAssignment;
use App\Models\StatusUpdate;
use App\Models\Payment;
use App\Models\Status;
use App\Models\Service;
use App\Models\Conv;
use App\Models\UserLogin;
use App\Models\Doc;
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

            if ($status_type != 3) {  
                $inputs['finali_date'] = null;
                $inputs['start_date'] = null;
                $inputs['end_date'] = null;
                $inputs['time_period'] = null;
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

            $new_status = (new StatusUpdate)->store($inputs);

            $status  = Client::where('id', $client_id)->update([
                'status' => $new_status,
                ]);

            if ($status_type ==  3) {
              $inputs = $inputs + [
                                  'offered_price' => $inputs['product_price'],
                                  'recieved_amount' => 0,
                                  'discount' => 0,
                                  'out_amount' => 0,
                  ];
            (new Payment)->store($inputs);
            }
            return apiResponseApp(true, 200, lang('Client created successfully'));


    	}catch(Exception $e){
			return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }

     // Create company 
    public function editClient(Request $request){
    	try{
    		  $inputs = $request->all();
      
            $validator = ( new Client )->ValidateClientAppUpdate( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }
            $user_id = \Auth::User()->id;
            $id = $inputs['id'];
            
            if (isset($inputs['name'])) {
              $name  = Client::where('id', $id)->update([
                'name' => $inputs['name'],
                ]);
            }


            if (isset($inputs['business_name'])) {
              $business_name  = Client::where('id', $id)->update([
                'business_name' => $inputs['business_name'],
                ]);
            }


            if (isset($inputs['phone_no'])) {
              $phone_no  = Client::where('id', $id)->update([
                'phone_no' => $inputs['phone_no'],
                ]);
            }


            if (isset($inputs['alt_contact'])) {
              $alt_contact  = Client::where('id', $id)->update([
                'alt_contact' => $inputs['alt_contact'],
                ]);
            }


            if (isset($inputs['address'])) {
              $address  = Client::where('id', $id)->update([
                'address' => $inputs['address'],
                ]);
            }


            if (isset($inputs['email'])) {
              $email  = Client::where('id', $id)->update([
                'email' => $inputs['email'],
                ]);
            }

            if (isset($inputs['email'])) {
              $email  = Client::where('id', $id)->update([
                'email' => $inputs['email'],
                ]);
            }

            if (isset($inputs['lead_head'])) {
                $lead = LeadAssignment::where('client_id', $id)->where('status', 1)->value('lead_head');
                if ($lead != $inputs['lead_head']) {
                    $lead_head  = Client::where('id', $id)->update([
                                  'lead_head' => $inputs['lead_head'],
                                  ]);
                    $lead_assignment  = LeadAssignment::where('client_id', $id)->update([
                                        'status' => 0,
                                        ]);
                    $user_type = UserLogin::where('id', $inputs['lead_head'])->value('user_type');
                    $company_id = Company::where('status', 1)->value('id');
                    $inputs = $inputs + [
                                  'client_id' => $id,
                                  'lead_head' => $inputs['lead_head'],
                                  'user_type' => $user_type,
                                  'user_id' => \Auth::User()->id,
                                  'w_e_f' => Carbon::now(),
                                  'status' => 1,
                                  'company_id' => $company_id,

                     ];
                    (new LeadAssignment)->store($inputs);
              }
            }
            return apiResponseApp(true, 200, lang('Client updated successfully'));

    	}catch(Exception $e){
			 return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }

   // Create company 
    public function updateStatus(Request $request){
      try{
            $inputs = $request->all();
            $validator = ( new Client )->ValidateClientStatus( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }

            $company_id = Client::where('id', $inputs['id'])->value('company_id');
            // $product_price = Client::where('id', $inputs['id'])->value('product_price');
            $user_id = \Auth::User()->id;
            $status_type = $inputs['status'];
            $inputs = $inputs + [
              'company_id' => $company_id,
              'user_id' => $user_id,
              'client_id' => $inputs['id'],
              'status_type' => $inputs['status'],
            ];
            if (isset($inputs['doc'])) {
                $file = $request->doc;
                foreach ($file as $files) {
                  $doc_file = rand(100000, 999999);
                  $fileExtension = $files->getClientOriginalExtension();
                  $files->move(public_path().'/uploads/doc/', $doc_file.'.'.$fileExtension);
                  unset($inputs['doc']);
                  $inputs = $inputs + [ 'doc' => $doc_file.'.'.$fileExtension ];
                  $doc= (new Doc)->store($inputs);
                }
            }
            if ($status_type != 3) {  
                $inputs['finali_date'] = null;
                $inputs['start_date'] = null;
                $inputs['end_date'] = null;
                $inputs['time_period'] = null;
            }
            $new_status = (new StatusUpdate)->store($inputs);
            $product_price = Client::where('id', $inputs['id'])->value('product_price');
            if ($status_type ==  3) {
              $inputs = $inputs + [
                                  'offered_price' => $product_price,
                                  'recieved_amount' => 0,
                                  'discount' => 0,
                                  'out_amount' => 0,
                  ];
              (new Payment)->store($inputs);
            }

            unset($inputs['status']);
            $inputs = $inputs + [ 'status' => $new_status];
            $client  = (new Client)->store($inputs, $inputs['id']);

            

            return apiResponseApp(true, 200, lang('Status updated successfully'));


      }catch(Exception $e){
      return apiResponseApp(false, 500, lang('messages.server_error'));
      }
    }


     //Client List
    public function clientList(){
        try{            
            $client = Client::get();
            if (count($client) != 0) {
              foreach ($client as $cl) {
                $status = StatusUpdate::where('id', $cl->status)->value('status_type');
                $cl['lead_status'] = Status::where('id', $status)->value('status_type');
              }
              return apiResponseApp(true, 200, null, [], $client);
            }else{
              return apiResponseApp(false, 400, lang('No Client record found'));
            }


        }catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }

    //Client List
    public function clientProfile(Request $request){
        try{            
            $inputs = $request->all();
          
            $validator = ( new Client )->ValidateClientProfile( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }

            $profile = Client::where('id', $inputs['id'])->first();
            $status = StatusUpdate::where('id', $profile->status)->value('status_type');
            $profile['status'] = Status::where('id', $status)->value('status_type');
            $profile['product'] = Service::where('id', $profile->product)->value('service_name');
            $profile['conv_type'] = Conv::where('id', $profile->conv_type)->value('conv_type');

            $profile['lead_head'] = UserLogin::where('id', $profile->lead_head)->value('name');
              return apiResponseApp(true, 200, null, [], $profile);


        }catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }

     //Client Name List
    public function clientNameList(){
        try{            
            $fields = ['name as name'];
            $client = Client::get($fields );
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
