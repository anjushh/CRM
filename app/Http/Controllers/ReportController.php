<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Client;
use App\Models\Status;
use App\Models\UserLogin;
use App\Models\PaymentStatus;
use Carbon;
use DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $client_datas = Client::
                        join('statuses', 'statuses.id' , '=', 'clients.status')
                        ->join('user_logins','user_logins.id','=','clients.lead_head')
                        ->select('clients.id as id','clients.created_at as created_at','clients.name as client_name', 'statuses.status_type as project_status','user_logins.name as lead_name')
                        ->get();
        $clients = Client::get();
        $status = Status::get();
        return view('reports.client_reports',compact('client_datas','clients','status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function client_data($client_id, $status)
    {
        $clients = new Client;
        $clients = $clients::join('statuses', 'statuses.id','=', 'clients.status')->join('user_logins','user_logins.id','=','clients.lead_head')->select('clients.id as id','clients.status as status','clients.created_at as created_at','clients.name as client_name', 'statuses.status_type as project_status','user_logins.name as lead_name');
        if ($client_id) {
            $clients = Client::clientFilter($clients, $client_id);
        }
        $data = $clients->get();
    }
    public function lead(){
        $leads = UserLogin::where('user_type','!=','1')->get();
        return view('reports.lead_reports',compact('leads'));
    }
    public function lead_data($id){
        $client_count = Client::where('lead_head',$id)->count();
        // $data[] =['client_count',] 
        return response(['client_count' => $client_count], 200);
    }
    public function pay_status($id){
        return PaymentStatus::where('client_id',$id)->orderBy('id','desc')->pluck('status')->first();
    }
}