<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['company_name','company_address','company_email','company_contact','company_gst','company_pan','company_logo','status'];

    public function edit($id)
    {
        return $this->where('id',$id)->first();
    }
}
