<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Validator;
use Paginate;
use DB;
use App\Http\Controllers\Controller;

class StatusController extends Controller
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
    public function create(Request $request, $id = null)
    {
        $create_records= Status::latest()->paginate(10);
        if($id != null){
            $edit_records = (new Status)->edit($id);
            return view('status.create',compact('create_records','edit_records'))->with('i', ($request->input('page', 1) - 1) * 10);
        }
        else {
            return view('status.create',compact('create_records'))->with('i', ($request->input('page', 1) - 1) * 10);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id = null)
    {
        $inputs = $request->all();
        $rules = array('status_type' => 'required');
        $valids = Validator::make($inputs, $rules);

        if($valids->fails()){
            return redirect()->route('status.create')->withErrors($valids)->withInput();
        }
        else {
            if($id != null){
                Status::find($id)->update($request->all());
            }
            else {
                Status::create($request->all());
            }
            return redirect()->route('status.create')->with('success','Data Submitted Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        //
    }
}
