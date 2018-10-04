<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	protected $fillable = ['company_id','user_id','client_id','remarks','rem_id'];

    public function createNotification($reminder, $company_id, $user_id){
        $this->company_id = $company_id;
    	$this->client_id = $reminder->client_id;
        $this->rem_id = $reminder->id;
    	$this->rem_date = $reminder->rem_date;
    	$this->read_status = 1;
    	$this->user_id = $user_id;
    	$this->remarks = $reminder->remarks;
    	$this->save();
    }
}
