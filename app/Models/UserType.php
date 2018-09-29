<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $fillable = ['user_type'];

    public function edit($id)
    {
        return $this->where('id',$id)->first();
    }
}
