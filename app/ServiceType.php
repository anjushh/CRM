<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $fillable = ['service_type'];

    public function edit($id)
    {
        return $this->where('id',$id)->first();
    }
}
