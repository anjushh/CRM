<?php

namespace App\Http\Controllers;

use App\Client;
use DB;
use App\LeadAssignment;
use Validator;
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
        $company_id = active_company();
        $services = DB::table('services')->where('company_id', $company_id)->get();
        $statuses = DB::table('statuses')->get();
        $convs = DB::table('convs')->get();
        $execus = DB::table('user_logins')->where('user_type','!=','1')->get();

        $user_id = user_data();
        if($user_id->user_type == 1) {
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id = null)
    {

        $company_id = active_company();

        // To get user_type
        $user = user_data();
        // To get user_type

        $status = ($request["status"] == "on") ? 1 : 0;
        $inputs = $request->all();   
        $rules = array(
            'name' => 'required',
            'business_name' => 'required',
            'address' => 'required',
            'phone_no' => 'required',
            'email' => 'required',
            'alt_contact' => 'required',
            'status' => 'required',
            'product' => 'required',
            'anni_date' => 'required',
            'birth_date' => 'required',
            'remarks' => 'required',
            'follow_ups' => 'required',
            'product_price' => 'required',
        );
        $valids = Validator::make($inputs, $rules);

        if($valids->fails()){
            return redirect()->route('client.create')->withErrors($valids)->withInput();
        }
        else {
            if($id != null){

                // Lead Assiggnment Code
                $lead = new LeadAssignment;
                $client_info = Client::where('id', $id)->first();
                $lead->client_id = $client_info->id;
                $lead->user_id = $user->id;
                $lead->user_type = $user->user_type;
                $lead->lead_head = $request->lead_head;
                $lead->w_e_f = date('Y-m-d H:i:s');
                $lead->w_e_t = 'null';
                $lead->company_id = $company_id;
                $new_status = $request->status;
                $lead->status = '1';
                $status_id = LeadAssignment::where('client_id', $client_info->id)->orderBy('id','desc')->limit(1)->pluck('id')->first();
                LeadAssignment::where('id', $status_id)->update(['status' => '0']);
                LeadAssignment::where('id', $status_id)->update(['w_e_t'=>date('Y-m-d H:i:s')]);
                Client::find($id)->update($request->all());
                $lead->save();
                // Lead Assiggnment Code
                return redirect()->route('client.create')->with('success','Data Updated Successfully');
            }
            else {
                $user_id = user_type();
                $company_id = active_company();
                $data = $request->all();
                $data['company_id'] = $company_id;
                $data['user_id'] = $user_id;
                Client::create($data);
                
                // Lead Assiggnment Code
                $lead = new LeadAssignment;
                $client_info = DB::table('clients')->latest()->first();
                if($client_info == null){
                    $lead->client_id = '1';
                }
                else {
                    $lead->client_id = $client_info->id;
                }
                $lead->user_id = $user->id;
                $lead->user_type = $user->user_type;
                $lead->lead_head = $request->lead_head;
                $lead->w_e_f = date('Y-m-d H:i:s');
                $lead->w_e_t = 'null';
                $lead->status = '1';
                $lead->company_id = $company_id;
                $lead->save();
                // Lead Assiggnment Code

                
                return redirect()->route('client.create')->with('success','Data Submitted Successfully');
            }
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
}
