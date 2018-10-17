<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Status;
use App\Models\Conv;
use App\Models\UserLogin;
use App\Models\StatusUpdate;
use App\Models\LeadAssignment;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use Validator;
use DB;
use Illuminate\Http\Request;

class ClientController extends Controller
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
        try {
            $company_id = active_company();
            $services = Service::where('company_id', $company_id)->get();
            $statuses = Status::get();
            $convs = Conv::get();
            $execus = UserLogin::where('user_type','!=','1')->get();
            $user_id = user_data();
            if($user_id->user_type == '1') {
                $create_records= Client::latest()->paginate(10);
            }
            else {
                $create_records= Client::latest()->where('user_id',$user_id->id)->paginate(10);    
            }
            if($id != null){
                $edit_records = (new Client)->edit($id);
                return view('client.create',compact('create_records','edit_records','services','statuses','convs','execus'))->with('i', ($request->input('page', 1) - 1) * 10);
            }
            else {
                return view('client.create',compact('create_records','services','statuses','convs','execus'))->with('i', ($request->input('page', 1) - 1) * 10);
            }
        }
        catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
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
        try {
            $company_id = active_company();

            // To get user_type
            $user = user_data();
            // To get user_type

            $status = ($request["status"] == "on") ? 1 : 0;
            $inputs = $request->all(); 
            $valids = (new Client)->ValidateClient($inputs);

            if($valids->fails()){
                return redirect()->route('client.create')->withErrors($valids)->withInput();
            }
            else {
                if($id != null){
                    
                    //Get Client Info
                    $client_info = Client::where('id', $id)->first();
                    
                    // Lead Assiggnment Code if Changed
                    if($client_info->lead_head != $request->lead_head){
                        $status_id = LeadAssignment::where('client_id', $client_info->id)->orderBy('id','desc')->limit(1)->pluck('id')->first();
                        LeadAssignment::where('id', $status_id)->update(['status' => '0']);
                        LeadAssignment::where('id', $status_id)->update(['w_e_t'=>date('Y-m-d H:i:s')]);
                        $leadid = (new LeadAssignment)->assignLead($client_info->id, $user, $request, $company_id);
                    }

                    // Update Client Data
                    Client::find($id)->update($request->all());
                    
                    // Lead Assiggnment Code

                    // Status Create Code
                    if($client_info->status != $request->status ){
                        $statid = (new StatusUpdate)->statusUpdate($client_info->id, $user, $request, $company_id);
                    }
                    // Status Create Code


                    // Payment Create Code
                    if($request->status == 3){
                        $statid = (new Payment)->paymentCreate($client_info->id, $user, $request, $company_id);
                    }
                    // Payment Create Code

                    return redirect()->route('client.create')->with('success','Data Updated Successfully');
                }
                else {
                    $user_id = user_data();
                    $company_id = active_company();
                    $data = $request->all();
                    $data['company_id'] = $company_id;
                    $data['user_id'] = $user_id->id;
                    // Create Data in Database
                    Client::create($data);
                    // Create Data in Database

                    $client_info = Client::latest()->first();

                    // Lead Assiggnment Code
                    $leadid = (new LeadAssignment)->assignLead($client_info->id, $user, $request, $company_id);
                    // Lead Assiggnment Code

                    // Status Update Code
                    $statid = (new StatusUpdate)->statusUpdate($client_info->id, $user, $request, $company_id);
                    // Status Update Code
                    
                    // Payment Update Code
                    if($request->status == 3){
                        $payid = (new Payment)->paymentCreate($client_info->id, $user, $request, $company_id);
                    }
                    // Payment Update Code
                    return redirect()->route('client.create')->with('success','Data Submitted Successfully');
                }
            }
        }
        catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    
    public function get_price(Request $request)
    {
        $service_price = DB::table('services')->where('id',$request->id)->pluck('service_price')->first();
        return response(['service_price' => $service_price], 200);
    }
    public function mail()
    {
       $name = 'Anju';
       Mail::to('anju.sharma045@gmail.com')->send(new SendMailable($name));
       return 'Email was sent';
    }
}
