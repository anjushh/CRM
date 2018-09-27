<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['client_id','company_id','user_id','offered_price','recieved_amount','discount','out_amount','inst_1','inst_2','inst_3','inst_date_1','inst_date_2','inst_date_3'];
	public function edit($id)
    {
        return $this->where('id',$id)->first();
    }
    public function client_name($id)
    {
    	$name = DB::table('clients')->where('id', $id)->pluck('name')->first();
    	return $name;
    }
    public function pay_id($id){
        $pay_id = DB::table('payment_statuses')->where('payment_id', $id)->OrderBy('id','desc')->pluck('id')->first();
        return $pay_id;
    }
}
