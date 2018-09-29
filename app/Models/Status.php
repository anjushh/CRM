<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;

    protected $fillable = ['status_type'];

    public function edit($id)
    {
        return $this->where('id',$id)->first();
    }

    //For App-- Khushboo
    public function validateStatus($inputs){
    	 $rules = [
            'status_type' => 'required|max:50',
        ];
        return \Validator::make($inputs, $rules);
    }

      //For App-- Khushboo
    public function validateStatusUpdate($inputs){
    	 $rules = [
            'status_type' => 'required|max:50',
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

    //For App-- Khushboo
    public function validateStatusDelete($inputs){
         $rules = [
            'id' => 'required|numeric',
        ];
        return \Validator::make($inputs, $rules);
    }
}
