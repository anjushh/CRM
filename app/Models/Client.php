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

    public static function allFilter($clients){
        return $clients->get();
    }

	public static function clientFilter($clients, $client_id){
		return $clients->where('clients.id', $client_id)->get();
    }
    
    public static function statusFiler($clients, $status){
		return $clients->where('clients.status', $status)->get();
    }

    public static function statusToFilter($clients, $status, $to_date){
        return $clients->where('clients.status', $status)->where('clients.created_at', '<=', $to_date)->get();
    }

    public static function statusToFromFilter($clients, $status, $to_date, $from_date){
        return $clients->where('clients.status', $status)->where('clients.created_at', '>=', $from_date)->where('clients.created_at', '<', $to_date)->get();
    }
    
    public static function statusFromFilter($clients, $status, $from_date){
        return $clients->where('clients.status', $status)->where('clients.created_at', '>=', $from_date)->get();
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
		return $clients->where('clients.status', $status)->where('clients.created_at', '>=', $from_date)->where('clients.created_at', '<', $to_date)->get();
    }
    
    //For Web-- Anju
    public static function leadDateFilter($leads, $to_date = null, $from_date = null, $lead_id = null){

        // When Lead is Selected

        if ($lead_id != null && $from_date == 0 && $to_date == 0 ){
            $leads1 = $leads->where('lead_head', $lead_id)->get();
        }

        // When All Options Selected

        if ($lead_id != null && $from_date != 0 && $to_date != 0 ){
            $leads1 = $leads->where('lead_head', $lead_id)->whereBetween('created_at',[$from_date, $to_date])->get();
        }

        // When Lead & From Date are Selected

        if ($lead_id != null && $from_date != 0 && $to_date == 0 ){
            $leads1 = $leads->where('lead_head', $lead_id)->where('created_at','>=', $from_date)->get();
        }

        // When Lead & To Date are Selected

        if ($lead_id != null && $from_date == 0 && $to_date != 0 ){
            $leads1 = $leads->where('lead_head', $lead_id)->where('created_at','<=', $to_date)->get();
        }

        // When None of the Options are Selected

        if ($lead_id == 0 && $from_date == 0 && $to_date == 0 ){
            $leads1 = $leads->get();
        }

        // When From & To Dates are Selected

        if ($lead_id == 0 && $from_date != 0 && $to_date != 0 ){
            $leads1 = $leads->get();
            $names = $leads1->groupBy('lead_head');
            foreach ($names as $key => $rs) {
                $arr['lead_name'] = UserLogin::where('id',$key)->pluck('name')->first();
                $arr['leads_count'] = $rs->where('created_at', '>=', $from_date)->where('created_at', '<', $to_date)->count();
                $arr['pending'] = $rs->where('status','1')->where('created_at', '>=', $from_date)->where('created_at', '<', $to_date)->count();
                $arr['process'] = $rs->where('status','2')->where('created_at', '>=', $from_date)->where('created_at', '<', $to_date)->count();
                $arr['close'] = $rs->where('status','3')->where('created_at', '>=', $from_date)->where('created_at', '<', $to_date)->count();
                $arr['refuse'] = $rs->where('status','4')->where('created_at', '>=', $from_date)->where('created_at', '<', $to_date)->count();
                $user_id = UserLogin::where('id', $key)->pluck('user_type')->first();
                $arr['desg'] = UserType::where('id',$user_id)->pluck('user_type')->first();
                $all[$key] = $arr;
            }
            return $all;
        }

        // When Only To Date is Selected

        if ($lead_id == 0 && $from_date == 0 && $to_date != 0 ){
            $leads1 = $leads->get();
            $names = $leads1->groupBy('lead_head');
            foreach ($names as $key => $rs) {
                $arr['lead_name'] = UserLogin::where('id',$key)->pluck('name')->first();
                $arr['leads_count'] = $rs->where('created_at','<=', $to_date)->count();
                $arr['pending'] = $rs->where('status','1')->where('created_at','<=', $to_date)->count();
                $arr['process'] = $rs->where('status','2')->where('created_at','<=', $to_date)->count();
                $arr['close'] = $rs->where('status','3')->where('created_at','<=', $to_date)->count();
                $arr['refuse'] = $rs->where('status','4')->where('created_at','<=', $to_date)->count();
                $user_id = UserLogin::where('id', $key)->pluck('user_type')->first();
                $arr['desg'] = UserType::where('id',$user_id)->pluck('user_type')->first();
                $all[$key] = $arr;
            }
            return $all;
        }

        // When Only From Date is Selected

        if ($lead_id == 0 && $from_date != 0 && $to_date == 0 ){
            $leads1 = $leads->get();
            $names = $leads1->groupBy('lead_head');
            foreach ($names as $key => $rs) {
                $arr['lead_name'] = UserLogin::where('id',$key)->pluck('name')->first();
                $arr['leads_count'] = $rs->where('created_at','>=', $from_date)->count();
                $arr['pending'] = $rs->where('status','1')->where('created_at','>=', $from_date)->count();
                $arr['process'] = $rs->where('status','2')->where('created_at','>=', $from_date)->count();
                $arr['close'] = $rs->where('status','3')->where('created_at','>=', $from_date)->count();
                $arr['refuse'] = $rs->where('status','4')->where('created_at','>=', $from_date)->count();
                $user_id = UserLogin::where('id', $key)->pluck('user_type')->first();
                $arr['desg'] = UserType::where('id',$user_id)->pluck('user_type')->first();
                $all[$key] = $arr;
            }
            return $all;
        }

        $names = $leads1->groupBy('lead_head');
        if(count($names) > 0) {
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

        else {
            $all['lead_name'] = UserLogin::where('id',$lead_id)->pluck('name')->first();
            $all['leads_count'] = '0';
            $all['pending'] = '0';
            $all['process'] = '0';
            $all['close'] = '0';
            $all['refuse'] = '0';
            $user_id = UserLogin::where('id', $lead_id)->pluck('user_type')->first();
            $all['desg'] = UserType::where('id',$user_id)->pluck('user_type')->first();
            return $all;
        }
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