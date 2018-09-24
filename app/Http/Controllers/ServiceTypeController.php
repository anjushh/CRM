<?php

namespace App\Http\Controllers;

use App\ServiceType;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ServiceTypeController extends Controller
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
        $create_records= ServiceType::latest()->paginate(10);
        if($id != null){
            $edit_records = (new ServiceType)->edit($id);
            return view('service_type.create',compact('create_records','edit_records'))->with('i', ($request->input('page', 1) - 1) * 10);
        }
        else {
            return view('service_type.create',compact('create_records'))->with('i', ($request->input('page', 1) - 1) * 10);
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
        $rules = array('service_type' => 'required');
        $valids = Validator::make($inputs, $rules);

        if($valids->fails()){
            return redirect()->route('service_type.create')->withErrors($valids)->withInput();
        }
        else {
            if($id != null){
                ServiceType::find($id)->update($request->all());
            }
            else {
                ServiceType::create($request->all());
            }
            return redirect()->route('service_type.create')->with('success','Data Submitted Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceType $serviceType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceType $serviceType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceType $serviceType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceType $serviceType)
    {
        //
    }
}
