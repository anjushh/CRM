<?php

namespace App\Http\Controllers;

use App\Models\Conv;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Http\Controllers\Controller;

class ConvController extends Controller
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
        $create_records= Conv::latest()->paginate(10);
        if($id != null){
            $edit_records = (new Conv)->edit($id);
            return view('conv_type.create',compact('create_records','edit_records'))->with('i', ($request->input('page', 1) - 1) * 10);
        }
        else {
            return view('conv_type.create',compact('create_records'))->with('i', ($request->input('page', 1) - 1) * 10);
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
        $rules = array('conv_type' => 'required');
        $valids = Validator::make($inputs, $rules);

        if($valids->fails()){
            return redirect()->route('conv_type.create')->withErrors($valids)->withInput();
        }
        else {
            if($id != null){
                Conv::find($id)->update($request->all());
            }
            else {
                Conv::create($request->all());
            }
            return redirect()->route('conv_type.create')->with('success','Data Submitted Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conv  $conv
     * @return \Illuminate\Http\Response
     */
    public function show(Conv $conv)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Conv  $conv
     * @return \Illuminate\Http\Response
     */
    public function edit(Conv $conv)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conv  $conv
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conv $conv)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conv  $conv
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conv $conv)
    {
        //
    }
}
