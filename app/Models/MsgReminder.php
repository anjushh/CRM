<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsgReminder extends Model
{

    use SoftDeletes;

    protected $fillable = ['client_id','user_id','company_id','remarks','rem_date','status'];

    // For Web --- Anju
    public function edit($id)
    {
        return $this->where('id',$id)->first();
    }

    // For Web -- Anju
    public function ValidateRequest($inputs){
    	$rules = [
            'rem_date' => 'required',
            'client_id' => 'required|numeric',
            'remarks' => 'required',
            'status' => 'required|numeric'
        ];
        return \Validator::make($inputs, $rules);
    }

    // For Web --- Anju To Get Client Name


    // public function createReminder($request, $client_id, $user_id, $company_id){
    // 	$this->company_id = $company_id;
    // 	$this->user_id = $user_id;
    // 	$this->client_id = $client_id;
    // 	$this->rem_date = $request->rem_date;
    // 	dd($this);
    // }

     //For Web --- Anju
    public function store($input, $id = null)
     {
     	if ($id) {
             return $this->find($id)->update($input);
        }
        else {
             return $this->create($input)->id;
        }
    } 

    //For web -- Anju
    public function msgRemindersData(){
    	$fields = [
    	'msg_reminders.id as id',
    	'msg_reminders.client_id as client_id',
    	'msg_reminders.remarks as remarks',
    	'msg_reminders.rem_date as rem_date',
    	'msg_reminders.status as status',
    	'c.name as client_name',
    	];
    	return $this->join('clients as c', 'c.id', '=', 'msg_reminders.client_id')->get($fields);
    }

    // For Web --- Anju From StatusUpdateController
    public function rem_Update($client_id,$rem_date,$company_id,$user_id,$remarks){
        $this->client_id = $client_id;
        $this->rem_date = $rem_date;
        $this->company_id = $company_id;
        $this->user_id = $user_id;
        $this->remarks = $remarks;
        $this->status = 1;
        $this->save();
    }

    // For Web --- Anju For Installments
    public function ins_rem_Update($company_id,$user_id,$request,$rem_date,$remarks){
        $this->client_id = $request->client_id;
        $this->rem_date = $rem_date;
        $this->company_id = $company_id;
        $this->user_id = $user_id;
        $this->remarks = $remarks;
        $this->status = 1;
        $this->save();
    }


    public function deleteAccount($id)
    {
        $this->where('id', $id)->delete();
    }

     // For Web -- Khushboo
    public function ValidateRequestApp($inputs){
        $rules = [
            'rem_date' => 'required',
            'client_id' => 'required|numeric',
            'remarks' => 'required',
            'status' => 'required|numeric'
        ];
        return \Validator::make($inputs, $rules);
    }
}
