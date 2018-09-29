<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conv extends Model
{
    use SoftDeletes;

    protected $fillable = ['conv_type'];
    public function edit($id)
    {
        return $this->where('id',$id)->first();
    }

    //For App-- Khushboo
    public function validateConv($inputs){
    	 $rules = [
            'conv_type' => 'required|max:50',
        ];
        return \Validator::make($inputs, $rules);
    }

    //For App-- Khushboo
    public function validateConvUpdate($inputs){
    	 $rules = [
            'conv_type' => 'required|max:50',
            'id' => 'required|numeric',
        ];
        return \Validator::make($inputs, $rules);
    }

    //For App-- Khushboo
    public function validateConvDelete($inputs){
         $rules = [
            'id' => 'required|numeric',
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
     
    public function deleteAccount($id)
    {
        $this->where('id', $id)->delete();
    }
}
