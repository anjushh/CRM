<?php

namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
    	$company_id = active_company();
    	$user = user_data();
    	$info = Client::where('company_id',$company_id)->where('lead_head',$user->id)->get();
        return view('profile',compact('user','info'));
    }
}
