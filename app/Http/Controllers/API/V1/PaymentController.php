<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Client;
use App\Models\Company;
use App\Models\PaymentStatus;

class PaymentController extends Controller
{
    //All Payment
    public function allPayment(){
    	try{            
            $payments = Payment::get();

            if (count($payments) != 0) {
            	foreach ($payments as $payment) {
            		$payment['client_name'] = Client::where('id', $payment->client_id)->value('name');
            		$payment['company_name'] = Company::where('id', $payment->company_id)->value('company_name');
            	}
            	return apiResponseApp(true, 200, null, [], $payments);
            }else{
            	return apiResponseApp(false, 400, 'No Payment Record found');
            }


        }catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }

    //Edit Payment
    public function editPayment(Request $request){
    	try{            
            $inputs = $request->all();

            $validator = ( new Payment )->validatePayment( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }
            $company_id = Payment::where('id', $inputs['payment_id'])->value('company_id');
            $client_id = Payment::where('id', $inputs['payment_id'])->value('client_id');
            $user_id = Payment::where('id', $inputs['payment_id'])->value('user_id');
           	$updatePayment = (new Payment)->store($inputs, $inputs['payment_id']);
           	$updatePaymentStatus = (new PaymentStatus)->updatePaymentStatus($company_id,$client_id,$user_id,$inputs['out_amount'],$inputs['payment_id']);


            return apiResponseApp(true, 200, 'Payment Updated Successfully');

        }catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }


    //Update Payment
    public function updatePayment(Request $request){
    	try{            
            $inputs = $request->all();

            $validator = ( new Payment )->validatePaymentUpdate( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }
            $company_id = Payment::where('id', $inputs['payment_id'])->value('company_id');
            $client_id = Payment::where('id', $inputs['payment_id'])->value('client_id');
            $user_id = Payment::where('id', $inputs['payment_id'])->value('user_id');
            if ($inputs['out_amount'] == 0) {
            	$status = 1;
            }else{
            	$status = 2;
            }
           	$updatePayment = (new Payment)->store($inputs, $inputs['payment_id']);
           	$updatePaymentStatus = (new PaymentStatus)->updatePaymentStatusReceived($company_id,$client_id,$user_id,$inputs['out_amount'],$inputs['payment_id'], $inputs['amt_rcvd'], $status, $inputs['pay_date']);


            return apiResponseApp(true, 200, 'Payment Updated Successfully');

        }catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }
}
