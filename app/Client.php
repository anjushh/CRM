<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name','business_name','address','phone_no','email','alt_contact','status','product','anni_date','birth_date','finali_date','start_date','end_date','time_period','remarks','follow_ups','product_price','user_id','lead_head','conv_type','company_id'];
    public function edit($id)
    {
        return $this->where('id',$id)->first();
    }

    //for App -- Khushboo
    public function validateClient($input){
    	 $rules = [
            'name' => 'required|max:30',
            'business_name' => 'required|max:100',
            'address' => 'required',
            'phone_no' => 'required|digits:10',
            'email' => 'required|max:50|email',
            'status' => 'required|numeric',
            'product' => 'required|numeric',
            'conv_type' => 'required|numeric',
            'lead_head' => 'required|numeric',
            'product_price' => 'required',
        ];
        return \Validator::make($inputs, $rules);
    }
}
