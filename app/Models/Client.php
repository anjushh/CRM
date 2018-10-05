<?php

namespace App\Models;

use App\Models\Status;
use App\Models\Client;
use App\Models\PaymentStatus;
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

       // For App --Khushboo
    public function ValidateClientStatus($inputs){
	    $rules = array(
	    	'id' => 'required|numeric',
	    	'remarks' => 'required',
	    	'status' => 'required|numeric',
	    );
	    $valids = Validator::make($inputs, $rules);
	    return $valids;
    }

    public function ValidateClientProfile($inputs){
	    $rules = array(
	    	'id' => 'required|numeric',
	    );
	    $valids = Validator::make($inputs, $rules);
	    return $valids;
    }
    
    // For Web --- Anju
    public function payment_status($id){
    	return PaymentStatus::where('client_id',$id)->orderBy('id','desc')->pluck('status')->first();
    }

    //For App-- Khushboo
    public function allclientReport(){
    	$fields =  [ 'id as client_id',
    	'name as client_name','created_at as joining_date', 'status as project_status'];
    	return $this->get($fields);
    }

    //For App-- Khushboo
    public function allclientReportName($name){
    	$fields =  [ 'id as client_id',
    	'name as client_name','created_at as joining_date', 'status as project_status'];
    	return $this->where('name', 'like', '%' . $name . '%')->get($fields);
    }

   
    //For Web --- Anju
	public static function clientFilter($clients, $client_id){
		return $clients->where('id', $client_id);
    }

     //For App-- Khushboo
   public function ValidateClientName($inputs){
	    $rules = array(
	    	'name' => 'required',
	    );
	    $valids = Validator::make($inputs, $rules);
	    return $valids;
    }

     //For App-- Khushboo
   public function ValidateClientByStatus($inputs){
	    $rules = array(
	    	'id' => 'required',
	    );
	    $valids = Validator::make($inputs, $rules);
	    return $valids;
    }

    //For App-- Khushboo
    public function allclientReportStatus($id){
    	$fields =  [ 'clients.id as client_id',
    	'clients.name as client_name','clients.created_at as joining_date', 'clients.status as project_status'];
    	return $this->join('status_updates as statusupdate', function($join) use ($id){
						    $join->on('statusupdate.id', '=', 'clients.status');
						    $join->on(function($query) use ($id)
						            {
						             $query->where('statusupdate.status_type', '=', $id);
						            });
					})->get($fields);
    }
}