<?php

namespace App\Http\Controllers;

use App\Models\UserType;
use Validator;
use Paginate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserTypeController extends Controller
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
        $user_records= UserType::latest()->paginate(10);
        return view('user_type.create',compact('user_records'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        $inputs = $request->all();
        $rules = array('user_type' => 'required');
        $valids = Validator::make($inputs, $rules);

        if($valids->fails()){
            return redirect()->route('user_type.create')->withErrors($valids)->withInput();
        }
        else { 
            UserType::create($request->all());
            return redirect()->back()->with('success','Data Submitted Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserType  $userType
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user_records= UserType::latest()->paginate(10);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserType  $userType
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $records = (new UserType)->edit($id);
        $user_records= UserType::latest()->paginate(10);
        return view('user_type.create',compact('user_records','records'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserType  $userType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        UserType::find($id)->update($request->all());
        $user_records= UserType::latest()->paginate(10);
        return view('user_type.create',compact('user_records'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserType  $userType
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserType $userType)
    {
        //
    }
}
