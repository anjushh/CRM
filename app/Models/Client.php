<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;
class Client extends Model
{
    protected $fillable = ['name','business_name','address','phone_no','email','alt_contact','status','product','anni_date','birth_date','finali_date','start_date','end_date','time_period','remarks','follow_ups','product_price','user_id','lead_head','conv_type','company_id'];
    
    public function edit($id)
    {
        return $this->where('id',$id)->first();
    }

    // For Web --Anju
    public function ValidateClient($inputs){
	    $rules = array(
	        'name' => 'required',
	        'business_name' => 'required',
	        'address' => 'required',
	        'phone_no' => 'required',
	        'email' => 'required',
	        'alt_contact' => 'required',
	        'status' => 'required',
	        'product' => 'required',
	        'anni_date' => 'required',
	        'birth_date' => 'required',
	        'remarks' => 'required',
	        'follow_ups' => 'required',
	        'product_price' => 'required',
	    );
	    $valids = Validator::make($inputs, $rules);
	    return $valids;
    }

    
}
