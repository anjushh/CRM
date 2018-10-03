<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusUpdate extends Model
{
    protected $fillable = ['client_id','status_type','next_followup','finali_date','start_date','end_date','time_period','remarks','user_id','company_id'];

    // For Web -- Anju
    public function statusUpdate($client_id, $user, $request, $company_id)
    {

    	$this->client_id = $client_id;
        $this->company_id = $company_id;
        $this->user_id = $user->id;
        if($request->status){
            $this->status_type = $request->status;
        }
        else {
            $this->status_type = $request->status_type;   
        }
        $this->next_followup = $request->next_followup;
        $this->finali_date = $request->finali_date;
        $this->start_date = $request->start_date;
        $this->end_date = $request->end_date;
        $this->time_period = $request->time_period;
        $this->remarks = $request->remarks;
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
