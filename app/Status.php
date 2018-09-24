<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['status_type'];
    public function edit($id)
    {
        return $this->where('id',$id)->first();
    }
}
