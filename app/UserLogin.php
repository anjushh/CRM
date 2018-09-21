<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
	protected $fillable = ['name','email','password','password_confirm','mobile','designation','user_type','status'];

    public function edit($id)
    {
        return $this->where('id',$id)->first();
    }
}
