<?php

namespace App\Models;

use App\Models\Status;
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
	        'name' => 'required|max:30',
	        'business_name' => 'required|max:100',
	        'address' => 'required',
	        'phone_no' => 'required|digits:10',
	        'email' => 'required|max:50|email',
	        'status' => 'required',
	        'product' => 'required',
	        'birth_date' => 'required',
	        'lead_head' => 'required',
	        'remarks' => 'required',
	        'follow_ups' => 'required',
	        'product_price' => 'required',
	        'conv_type' => 'required',
	    );
	    $valids = Validator::make($inputs, $rules);
	    return $valids;
    }

    // For Web --- Anju
    public function status($id){
    	$status = StatusUpdate::where('client_id',$id)->OrderBy('id','desc')->pluck('status_type')->first();
    	return Status::where('id', $status)->pluck('status_type')->first();
    }

     // For App --Khushboo
    public function ValidateClientApp($inputs){
	    $rules = array(
	        'name' => 'required|max:30',
	        'business_name' => 'required|max:100',
	        'address' => 'required',
	        'phone_no' => 'required|digits:10',
	        'email' => 'required|max:50|email',
	        'status' => 'required',
	        'product' => 'required',
	        'birth_date' => 'required',
	        'lead_head' => 'required',
	        'remarks' => 'required',
	        'follow_ups' => 'required',
	        'product_price' => 'required',
	        'conv_type' => 'required',
	    );
	    $valids = Validator::make($inputs, $rules);
	    return $valids;
    }

      // For App --Khushboo
    public function ValidateClientAppUpdate($inputs){
	    $rules = array(
	    	'id' => 'required|numeric'
	    );
	    $valids = Validator::make($inputs, $rules);
	    return $valids;
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

    // For Web --- Anju
    public function status_id($id){
        return StatusUpdate::where('client_id',$id)->OrderBy('id','desc')->pluck('id')->first();
    }

    
}
