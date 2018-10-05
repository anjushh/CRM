<?php

namespace App\Models;

use App\Models\Status;
use App\Models\Client;
use App\Models\UserType;
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
		return $clients->where('clients.id', $client_id)->get();
    }
    
    public static function statusFiler($clients, $status){
		return $clients->where('clients.status', $status)->get();
    }

    public static function fromFilter($clients, $from_date){
		return $clients->where('clients.created_at', '>=', $from_date)->get();
    }
    public static function toFilter($clients, $to_date){
		return $clients->where('clients.created_at', '<=', $to_date)->get();
    }
    public static function fromtoFilter($clients, $to_date, $from_date){
		return $clients->whereBetween('clients.created_at',[$from_date,$to_date])->get();
    }
    public static function stafFilter($clients, $status, $to_date, $from_date){
		return $clients->whereBetween('clients.created_at',[$from_date,$to_date])->where('clients.status', $status)->get();
    }
    public static function leadFilter($leads, $lead_id){
    	$leads = $leads->where('lead_head', $lead_id)->get();
    	$arr['lead_name'] = UserLogin::where('id',$lead_id)->pluck('name')->first();
    	$arr['leads_count'] = $leads->count();
    	$arr['pending'] = $leads->where('status',1)->count();
    	$arr['process'] = $leads->where('status',2)->count();
    	$arr['close'] = $leads->where('status',3)->count();
    	$arr['refuse'] = $leads->where('status',4)->count();
    	$user_id = UserLogin::where('id',$lead_id)->pluck('user_type')->first();
    	$arr['desg'] = UserType::where('id',$user_id)->pluck('user_type')->first();
    	return $arr;
    }
    public static function leadDateFilter($leads, $to_date, $from_date){
    	$leads1 = $leads->whereBetween('created_at',[$from_date, $to_date])->get();
    	$names = $leads1->groupBy('lead_head');
    	foreach ($names as $key => $rs) {
    		$arr['lead_name'] = UserLogin::where('id',$key)->pluck('name')->first();
    		$arr['leads_count'] = $rs->count();
    		$arr['pending'] = $rs->where('status','1')->count();
    		$arr['process'] = $rs->where('status','2')->count();
    		$arr['close'] = $rs->where('status','3')->count();
    		$arr['refuse'] = $rs->where('status','4')->count();
    		$user_id = UserLogin::where('id', $key)->pluck('user_type')->first();
    		$arr['desg'] = UserType::where('id',$user_id)->pluck('user_type')->first();
    		$all[$key] = $arr;
    	}
    	return $all;
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