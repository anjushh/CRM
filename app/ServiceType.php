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

    public function deleteAccount($id)
    {
        $this->where('id', $id)->delete();
    }

     //For App---- Khushboo
    public function validateServiceType($inputs){
        $rules = [
            'service_type' => 'required|max:50',
        ];
        return \Validator::make($inputs, $rules);
    }

     //For App---- Khushboo
    public function validateServiceTypeEdit($inputs){
        $rules = [
            'service_type' => 'required|max:50',
            'id' => 'required|numeric',
        ];
        return \Validator::make($inputs, $rules);
    }

     //For App---- Khushboo
    public function validateServiceTypeDelete($inputs){
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
}
