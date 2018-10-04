<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    protected $fillable = ['client_id','company_id','user_id','out_amount','status','pay_date','amt_rcvd','status','payment_id'];
    
    public function edit($id)
    {
        return $this->where('id',$id)->first();
    }
    public function out_amount($id) {
    	$pay_id = DB::table('payment_statuses')->where('payment_id', $id)->OrderBy('id','desc')->pluck('out_amount')->first();
        return $pay_id;
    }
    public function payment_id($id) {
    	$pay_id = DB::table('payment_statuses')->where('id', $id)->pluck('payment_id')->first();
        return $pay_id;
    }
    public function ValidateData($inputs){
        $rules = [
            'offered_price' => 'required',
            'recieved_amount' => 'required',
            'discount' => 'required',
            'out_amount' => 'required',
            'inst_date_1' => 'nullable|required_with:inst_1|date|after:yesterday',
            'inst_date_2' => 'nullable|required_with:inst_2|date|after_or_equal:inst_date_1',
            'inst_date_3' => 'nullable|required_with:inst_3|date|after_or_equal:inst_date_2',
        ];
        return \Validator::make($inputs, $rules);
    }
    public function PaymentStatusUpdate($company_id,$client_id,$user_id,$request,$id){
        $this->company_id = $company_id;
        $this->client_id = $client_id;
        $this->user_id = $user_id;
        $this->payment_id = $id;
        $this->amt_rcvd = null;
        $this->out_amount = $request->out_amount;
        $this->status = null;
        $this->pay_date = null;
        $this->save();
    }
}
