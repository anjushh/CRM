<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeadAssignment extends Model
{
    protected $fillable = ['client_id','user_id','user_type','lead_head','w_e_f','w_e_t','status','company_id'];
}
