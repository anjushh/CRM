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
}
