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
            'service_type' => 'required|max:50',
        ];
        return \Validator::make($inputs, $rules);
    }
}
