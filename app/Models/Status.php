<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['status_type'];
    public function edit($id)
    {
        return $this->where('id',$id)->first();
    }
}
