<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['service_name','parent_id','company_id','service_type','service_price','status'];

	public function edit($id)
    {
        return $this->where('id',$id)->first();
    }

    public function parent_id($id){
    	$child_ids = DB::table('services')->where('parent_id', $id)->get();
    	return $child_ids;
    }

    //For App-- Khushboo
    public function validateService($inputs){
    	$rules = [
            'service_name' => 'required|max:50',
            'parent_id' => 'numeric',
            'service_type' => 'required|numeric',
            'service_price' => 'required',
            'status' => 'required|numeric'
        ];
        return \Validator::make($inputs, $rules);
    }

     //For App-- Khushboo
    public function validateServiceEdit($inputs){
        $rules = [
            'id' => 'required|numeric'
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
