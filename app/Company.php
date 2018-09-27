<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['company_name','company_address','company_email','company_contact','company_gst','company_pan','company_logo','status'];

    public function edit($id)
    {
        return $this->where('id',$id)->first();
    }

    
    public function deleteAccount($id)
    {
        $this->where('id', $id)->delete();
    }

  	//For App---- Khushboo
    public function validateCompany($inputs){
        $rules = [
            'company_name' => 'required|max:50',
            'company_address' => 'required|max:100',
            'company_email' => 'required|max:50|email',
            'company_contact' => 'required|digits:10',
            'company_gst' => 'required|max:30',
            'company_pan' => 'required|max:30',
            'status' => 'required|numeric',
            'company_logo' => 'required|mimes:jpg,jpeg,bmp,png|max:1024',
        ];
        
        $messages = [
            'company_logo.max' => 'Company Logo size must be less than 1MB',
            'company_logo.required' => 'Company Logo is required',
            'company_logo.mimes' => 'Company Logo must be of type jpeg,bmp,png',
        ];
        return \Validator::make($inputs, $rules, $messages);
    }

    //For App---- Khushboo
    public function validateCompanyEdit($inputs){
        $rules = [
            'id' => 'required|numeric',
        ];
        
        $messages = [
            'company_logo.max' => 'Company Logo size must be less than 1MB',
            'company_logo.mimes' => 'Company Logo must be of type jpeg,bmp,png',
        ];
        return \Validator::make($inputs, $rules, $messages);
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
