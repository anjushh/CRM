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
    
    public function client_data($client_id, $status, $from_date, $to_date)
    {
        $clients = new Client;
        $clients = Client::join('statuses', 'statuses.id','=', 'clients.status')->join('user_logins','user_logins.id','=','clients.lead_head')->select('clients.id as id','clients.status as status','clients.created_at as created_at','clients.name as client_name', 'statuses.status_type as project_status','user_logins.name as lead_name');

        // When only Client is selected
        if ($client_id != 0 && $status == 0 && $to_date == 0 && $from_date == 0) {
            $clients = Client::clientFilter($clients, $client_id);
        }
        
        // When only Status is selected
        if ($client_id == 0 && $status != 0 && $to_date == 0 && $from_date == 0) {
            $clients = Client::statusFiler($clients, $status);
        }

        // When To Date & From Date selected
        if ($client_id == 0 && $status == 0 && $to_date != 0 && $from_date != 0) {
            $clients = Client::fromtoFilter($clients, $to_date, $from_date);
        }

        // When only From Date is selected
        if ($client_id == 0 && $status == 0 && $to_date == 0 && $from_date != 0) {
            $clients = Client::fromFilter($clients, $from_date);
        }

        // When only To Date is selected
        if ($client_id == 0 && $status == 0 && $to_date != 0 && $from_date == 0) {
            $clients = Client::toFilter($clients, $to_date);
        }

        // When To Date, From Date & Status is selected
        if ($client_id == 0 && $status != 0 && $to_date != 0 && $from_date != 0) {
            $clients = Client::stafFilter($clients, $status, $to_date, $from_date);
        }
        return response(['clients' => $clients], 200);   
    }


    public function lead(){
        $leads = UserLogin::where('user_type','!=','1')->get();
        return view('reports.lead_reports',compact('leads'));
    }
    public function lead_data($lead_id, $from_date, $to_date){
        $leads = new Client;
        // When only Lead is selected
        if ($lead_id != 0 && $to_date == 0 && $from_date == 0) {
            $leads = Client::leadFilter($leads, $lead_id);
        }
        // When Dates selected
        if ($lead_id == 0 && $to_date != 0 && $from_date != 0) {
            $leads = Client::leadDateFilter($leads, $to_date, $from_date);
        }
        return response(['leads' => $leads], 200);
    }
    public function pay_status($id){
        return PaymentStatus::where('client_id',$id)->orderBy('id','desc')->pluck('status')->first();
    }
}