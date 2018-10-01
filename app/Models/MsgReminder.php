<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsgReminder extends Model
{
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
}
