<?php

namespace App\Http\Controllers;

use App\Models\StatusUpdate;
use App\Models\Client;
use App\Models\Doc;
use DB;
use Illuminate\Http\Request;

class StatusUpdateController extends Controller
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
    public function create(Request $request, $id = null, $id1 = null)
    {
        $client_id = $id1;
        $statuses = DB::table('statuses')->get();
        $edit_records = DB::table('status_updates')->where('id',$id)->first();
        return view('status_update.edit',compact('statuses','edit_records','client_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id = null, $id1 = null)
    {
        $company_id = active_company();
        $user_id = user_data();
        if($request->doc != null){
            $all_files = $request->doc;
            foreach($all_files as $all_file) {
                $filename = $all_file->getClientOriginalName();
                $filename = rand(100000, 999999);
                $fileExtension = $all_file->getClientOriginalExtension();
                $name = str_slug($request->filename).'.'.$all_file->getClientOriginalExtension();
                $path = $all_file->storeAs('doc',$filename.'.'.$fileExtension,'public');

                // Document Model
                $doc = new Doc;
                $doc['company_id'] = $company_id;
                $doc['user_id'] = $user_id->id;
                $doc['client_id'] = $id1;
                $doc['status_type'] = $request->status_type;
                $doc['doc']= $path;
                $doc->save();
                // Document Model
            }
            
        }
        // Status Update Code
        $stat = $request->all();
        if($request->status_type == 3){
            $stat['next_followup'] = null;
        }
        $stat['status_type'] = $request->status_type;
        $stat['client_id'] = $id1;
        $stat['company_id'] = $company_id;
        $stat['user_id'] = $user_id->id;
        $stat['finali_date'] = $request->finali_date;
        $stat['start_date'] = $request->start_date;
        $stat['end_date'] = $request->end_date;
        $stat['time_period'] = $request->time_period;
        // Status Update Code

        StatusUpdate::create($stat);


        // Client Table Update
        DB::table('clients')->where('id',$id1)->update(['status' => $request->status_type]);

        return redirect()->route('client.create')->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StatusUpdate  $statusUpdate
     * @return \Illuminate\Http\Response
     */
    public function show(StatusUpdate $statusUpdate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StatusUpdate  $statusUpdate
     * @return \Illuminate\Http\Response
     */
    public function edit(StatusUpdate $statusUpdate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StatusUpdate  $statusUpdate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StatusUpdate $statusUpdate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StatusUpdate  $statusUpdate
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatusUpdate $statusUpdate)
    {
        //
    }
}
