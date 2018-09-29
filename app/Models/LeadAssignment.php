<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadAssignment extends Model
{
    protected $fillable = ['client_id','user_id','user_type','lead_head','w_e_f','w_e_t','status','company_id'];

    //For web--  Anju
    public function assignLead($client_info, $user, $request,  $company_id){
        if($client_info == null){
            $this->client_id = '1';
        }
        else {
            $this->client_id = $client_info;
        }
        $this->user_id = $user->id;
        $this->user_type = $user->user_type;
        $this->lead_head = $request->lead_head;
        $this->w_e_f = date('Y-m-d H:i:s');
        $this->w_e_t = 'null';
        $this->company_id = $company_id;
        $this->status = 1;
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
