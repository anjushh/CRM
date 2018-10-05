<?php

namespace App\Models;
use App\Models\Client;
use App\Models\StatusUpdate;
use App\Models\UserType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLogin extends Model
{
    use SoftDeletes;

	protected $fillable = ['name','email','password','password_confirm','mobile','designation','user_type','status'];

    public function edit($id)
    {
        return $this->where('id',$id)->first();
    }

    public function deleteAccount($id)
    {
        $this->where('id', $id)->delete();
    }


    //For App---- Khushboo
    public function validateUser($inputs){
        $rules = [
            'mobile' => 'required|digits:10|numeric',
            'email' => 'required|email|max:50',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6',
            'designation' => 'required|max:30',
            'name' => 'required|max:30',
            'status' => 'required|numeric',
            'user_type' => 'required|numeric',
        ];
        return \Validator::make($inputs, $rules);
    }

    //For App---- Khushboo
    public function validateUserEdit($inputs){
        $rules = [
            'user_id' => 'required|numeric',
            // 'mobile' => 'digits:10|numeric',
            // 'email' => 'email|max:50',
            // 'password' => 'min:6',
            // 'confirm_password' => 'min:6',
            // 'designation' => 'max:30',
            // 'name' => 'max:30',
            // 'status' => 'numeric',
            // 'user_type' => 'numeric',
        ];
        return \Validator::make($inputs, $rules);
    }

     //For App---- Khushboo
    public function validateUserDelete($inputs){
        $rules = [
            'user_id' => 'required|numeric',
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
    public function pro_count($id){
        $client_count = Client::where('lead_head',$id)->count();
        return $client_count;
    }
    public function close_count($id){
        $client_count = Client::where('lead_head',$id)->where('status',3)->count();
        return $client_count;
    }
    public function pen_count($id){
        $client_count = Client::where('lead_head',$id)->where('status',1)->count();
        return $client_count;
    }
    public function refuse_count($id){
        $client_count = Client::where('lead_head',$id)->where('status',4)->count();
        return $client_count;
    }
    public function desg($id){
        $client_count = UserType::where('id',$id)->pluck('user_type')->first();
        return $client_count;
    }
    
}
