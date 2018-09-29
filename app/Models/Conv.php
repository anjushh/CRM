<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conv extends Model
{
    protected $fillable = ['conv_type'];
    public function edit($id)
    {
        return $this->where('id',$id)->first();
    }
}
