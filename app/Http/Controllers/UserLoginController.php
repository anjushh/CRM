<?php

namespace App\Http\Controllers;

use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Session;
use Paginate;
use Validator;

class UserLoginController extends Controller
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
    public function create(Request $request)
    {
        $user_datas = DB::table('user_types')->get();
        $create_records= UserLogin::latest()->paginate(10);
        return view('user.create',compact('create_records','user_datas'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id = null)
    {
        $status = ($request["status"] == "on") ? 1 : 0;
        $inputs = $request->all();
        $user_datas = DB::table('user_types')->get();
        $rules = array(
            'name' => 'required|distinct',
            'email' => 'required|distinct',
            'designation' => 'required',
            'mobile' => 'required|digits:10',
            'user_type' => 'required',
            'password_confirm' => 'same:password'
        );
        $messages = array(
            'name.distinct'=>'Name has a duplicate value.',
            'email.distinct'=>'Email has a duplicate value.',
        );
        $name = $request->name;
        $email = $request->email;
        
        $valids = Validator::make($inputs, $rules);
        if($valids->fails()){
            return redirect()->route('user.create')->withErrors($valids)->withInput();
        }
        else {
            if($id != null){
                $data = ($request->password != null) ? $request->all() : $request->except(['password', 'password_confirm']);
                $data['status'] = $status;
                UserLogin::find($id)->update($data);
                $create_records= UserLogin::latest()->paginate(10);
                return redirect()->route('user.create')->with('i', ($request->input('page', 1) - 1) * 10);
            }
            else {
                if (UserLogin::where([ ["name", "=", $name ]])->exists()) {
                    return redirect()->route('user.create')->with('message','Name has a duplicate Value');
                }
                if (UserLogin::where([ ["email", "=", $email ]])->exists()) {
                    return redirect()->route('user.create')->with('message','Email has a duplicate Value');
                }
                else {
                    $data = $request->all();
                    $data['status'] = $status;
                    $data['password'] = Hash::make($request->password);
                    UserLogin::create($data);
                    return redirect()->route('user.create',compact('user_datas'))->with('success','Data Submitted Successfully');
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserLogin  $userLogin
     * @return \Illuminate\Http\Response
     */
    public function show(UserLogin $userLogin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserLogin  $userLogin
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $user_datas = DB::table('user_types')->get();
        $edit_records = (new UserLogin)->edit($id);
        $create_records= UserLogin::latest()->paginate(10);
        return view('user.create',compact('create_records','edit_records','user_datas'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserLogin  $userLogin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserLogin $userLogin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserLogin  $userLogin
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserLogin $userLogin)
    {
        //
    }
}
