<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class DeviceTokens extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'device_token', 'device_type'];
    

    //For App-- Khushboo
    public function validatetoken($inputs){
         $rules = [
            'device_token' => 'required',
            'device_type' => 'required',
        ];
        return \Validator::make($inputs, $rules);
    }

    //For App --- Khushboo
    public function store($input, $id = null)
     {
         if ($id) {
             return $this->find($id)->update($input);
         } else {
             return $this->create($input)->id;
         }
     } 
     
}
