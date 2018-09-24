<?php

namespace App\Http\Controllers;

use App\LeadAssignment;
use DB;
use Illuminate\Http\Request;

class LeadAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_id = active_company();
        
        $create_records = DB::table('lead_assignments')
             ->select('client_id', DB::raw('count(*) as total'))
             ->groupBy('client_id')->get();
        foreach ($create_records as $key => $create_record) {
            $records[] = DB::table('lead_assignments')->where('client_id',2)->get();
        }
        return view('admin.lead_assignment',compact('records'));
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
     * @param  \App\LeadAssignment  $leadAssignment
     * @return \Illuminate\Http\Response
     */
    public function show(LeadAssignment $leadAssignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LeadAssignment  $leadAssignment
     * @return \Illuminate\Http\Response
     */
    public function edit(LeadAssignment $leadAssignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LeadAssignment  $leadAssignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeadAssignment $leadAssignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LeadAssignment  $leadAssignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeadAssignment $leadAssignment)
    {
        //
    }
}
