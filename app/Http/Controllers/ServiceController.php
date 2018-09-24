<?php

namespace App\Http\Controllers;

use App\Service;
use App\ServicePrice;
use App\ServiceType;
use Validator;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
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
        $company_id = active_company();
        $service_types = ServiceType::get();
        $parent_ids = Service::where('company_id', $company_id)->get();
        $create_records= Service::latest()->paginate(10);
        if($id != null){
            $edit_records = (new Service)->edit($id);
            return view('services.create', compact('parent_ids','create_records','edit_records','service_types'))->with('i', ($request->input('page', 1) - 1) * 10);
        }
        else {
            return view('services.create', compact('parent_ids','service_types','create_records'))->with('i', ($request->input('page', 1) - 1) * 10);
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

        $company_id = active_company();
        $status = ($request["status"] == "on") ? 1 : 0;
        $inputs = $request->all();   
        $rules = array(
            'service_name' => 'required',
            'service_type' => 'required',
            'service_price' => 'required',
        );
        $valids = Validator::make($inputs, $rules);

        if($valids->fails()){
            return redirect()->route('services.create')->withErrors($valids)->withInput();
        }
        else {
            if($id != null){
                // Service Price

                $cost = new ServicePrice;
                $item_info = Service::where('id', $id)->first();
                $cost->service_id = $item_info->id;
                $cost->service_price = $request->service_price;
                $cost->wef = date('Y-m-d H:i:s');
                $cost->wet = 'null';
                $cost->company_id = $company_id;
                $new_status = $request->status;
                $cost->status = '1';
                $status_id = ServicePrice::where('service_id', $item_info->id)->orderBy('id','desc')->limit(1)->pluck('id')->first();
                ServicePrice::where('id', $status_id)->update(['status' => '0']);
                ServicePrice::where('id', $status_id)->update(['wet'=>date('Y-m-d H:i:s')]);
                $item_info->save();
                $status = ($request["status"] == "on") ? 1 : 0;
                $data = $request->all();
                $data['status'] = $status;
                Service::find($id)->update($data);
                $cost->save();
                return redirect()->route('services.create')->with('success','Data Updated Successfully');
            }
            else {
                $data = $request->all();
                $data['company_id'] = $company_id;
                $data['status'] = $status;
                Service::create($data);

                // Service Price
                $cost = new ServicePrice;
                $service_info = DB::table('services')->latest()->first();
                $cost->service_id = $service_info->id;
                $cost->company_id = $company_id;
                $cost->service_price = $service_info->service_price;
                $cost->wef = date('Y-m-d H:i:s');
                $cost->wet = 'null';
                $cost->status = '1';
                $cost->save();
                // Service Price

                return redirect()->route('services.create')->with('success','Data Submitted Successfully');
            }   
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        //
    }
}
