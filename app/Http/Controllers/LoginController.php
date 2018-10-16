<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Validator;
use Session;
use DB;
use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Login  $login
     * @return \Illuminate\Http\Response
     */
    public function show(Login $login)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Login  $login
     * @return \Illuminate\Http\Response
     */
    public function edit(Login $login)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Login  $login
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Login $login)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Login  $login
     * @return \Illuminate\Http\Response
     */
    public function destroy(Login $login)
    {

    }
    public function login()
    {
        return view('login.login');
    }
    
    public function loginstore(Request $request)
    {   
        $userData = UserLogin::where('email', $request->email)->first();
        // dd($request);
        $password = \Hash::check($request->password, $userData->password);
        if ($password) {
            if( $userData->status == 1) {
                $request->session()->put('userdata', $userData);
                $data = $request->session()->all();
                return redirect()->route('dashboard')->with('success','you logged in succesfully');
            }
            else {
                return redirect()->route('login.login')->with('failed','Your Status is inactive');
            }
        }
        else {
            return redirect()->route('login.login')->with('failed','Credential combination is invalid');
        }
    }
    public function logout(Request $request)
    {
        $request->session()->forget('userdata');
        $request->session()->flush();
        return redirect()->route('login.login')->with('logout', 'you have been logged out');
    }
}