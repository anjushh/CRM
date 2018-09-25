<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusUpdate extends Model
{
    protected $fillable = ['client_id','status_type','next_followup','finali_date','start_date','end_date','time_period','remarks','user_id','company_id'];
}
