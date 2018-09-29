<?php

namespace App\Models;
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
        $pay_id = DB::table('payment_statuses')->where('payment_id',$id)->OrderBy('id','desc')->pluck('id')->first();
        return $pay_id;
    }
    public function paymentCreate($client_id, $user, $request, $company_id){
        $this->client_id = $client_id;
        $this->company_id = $company_id;
        $this->user_id = $user->id;
        $this->offered_price = $request->product_price;
        $this->save();
    }

     //For App --- Khushboo
    public function store($input, $id = null)
     {
         if ($id) {
             return $this->find($id)->update($input);
         } else {
             return $this->create($input)->id;
         }
     } 
}
