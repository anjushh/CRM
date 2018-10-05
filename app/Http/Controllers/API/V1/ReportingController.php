<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\StatusUpdate;
use App\Models\Status;
use App\Models\Payment;
use App\Models\PaymentStatus;

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
