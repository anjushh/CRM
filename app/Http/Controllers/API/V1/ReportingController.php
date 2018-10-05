<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\StatusUpdate;
use App\Models\Status;
use App\Models\Payment;
use App\Models\PaymentStatus;
use App\Models\LeadAssignment;
use App\Models\UserLogin;

class ReportingController extends Controller
{
    //All Client Reports
    public function allClientReports(){
    	try{            
            $clients = (new Client)->allclientReport();

            if (count($clients) != 0) {
            	foreach ($clients as $client) {
            		$status_type = StatusUpdate::where('id', $client->project_status)->value('status_type');
            		$client['project_status'] = Status::where('id', $status_type)->value('status_type');
            		$payment = Payment::where('client_id', $client->client_id)->value('id');
            		$payment_status = PaymentStatus::where('id', $payment)->orderBy('created_at', 'desc')->limit(1)->value('status');
            		if ($payment_status == 2) {
            			$payment_status = 'Completed';
            		}else{
            			$payment_status = 'Pending';
            		}
            		$client['payment_status'] = $payment_status;
            		$lead_head = LeadAssignment::where('client_id', $client->client_id)->where('status', 1)->orderBy('created_at', 'desc')->limit(1)->value('lead_head');
            		$client['lead_manager'] = UserLogin::where('id', $lead_head)->value('name');
            	}
            	return apiResponseApp(true, 200, null, [], $clients);
            }else{
            	return apiResponseApp(false, 400, 'No client Record found');
            }


        }catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }

    //All Client Reports by name
    public function allClientReportsName(Request $request){
    	try{     

    		$inputs = $request->all();

            $validator = ( new Client )->ValidateClientName( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }      
            $clients = (new Client)->allclientReportName($inputs['name']);

            if (count($clients) != 0) {
            	foreach ($clients as $client) {
            		$status_type = StatusUpdate::where('id', $client->project_status)->value('status_type');
            		$client['project_status'] = Status::where('id', $status_type)->value('status_type');
            		$payment = Payment::where('client_id', $client->client_id)->value('id');
            		$payment_status = PaymentStatus::where('id', $payment)->orderBy('created_at', 'desc')->limit(1)->value('status');
            		if ($payment_status == 2) {
            			$payment_status = 'Completed';
            		}else{
            			$payment_status = 'Pending';
            		}
            		$client['payment_status'] = $payment_status;
            		$lead_head = LeadAssignment::where('client_id', $client->client_id)->where('status', 1)->orderBy('created_at', 'desc')->limit(1)->value('lead_head');
            		$client['lead_manager'] = UserLogin::where('id', $lead_head)->value('name');
            	}
            	return apiResponseApp(true, 200, null, [], $clients);
            }else{
            	return apiResponseApp(false, 400, 'No client Record found');
            }


        }catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }

    //All Client Reports by status
    public function allClientReportsStatus(Request $request){
    	try{     

    		$inputs = $request->all();

            $validator = ( new Client )->ValidateClientByStatus( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }      
            $clients = (new Client)->allclientReportStatus($inputs['id']);

            if (count($clients) != 0) {
            	foreach ($clients as $client) {
            		$status_type = StatusUpdate::where('id', $client->project_status)->value('status_type');
            		$client['project_status'] = Status::where('id', $status_type)->value('status_type');
            		$payment = Payment::where('client_id', $client->client_id)->value('id');
            		$payment_status = PaymentStatus::where('id', $payment)->orderBy('created_at', 'desc')->limit(1)->value('status');
            		if ($payment_status == 2) {
            			$payment_status = 'Completed';
            		}else{
            			$payment_status = 'Pending';
            		}
            		$client['payment_status'] = $payment_status;
            		$lead_head = LeadAssignment::where('client_id', $client->client_id)->where('status', 1)->orderBy('created_at', 'desc')->limit(1)->value('lead_head');
            		$client['lead_manager'] = UserLogin::where('id', $lead_head)->value('name');
            	}
            	return apiResponseApp(true, 200, null, [], $clients);
            }else{
            	return apiResponseApp(false, 400, 'No client Record found');
            }


        }catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }
}
