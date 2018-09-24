<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicePrice extends Model
{
    protected $fillable = ['service_id','service_price','w.e.f','w.e.t','status','company_id'];
}
