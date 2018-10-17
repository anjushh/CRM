<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\UserLogin;
use App\Models\Status;
use DB;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function index(){
        
    	$projects = Client::get();
    	$total_projects = Client::count();
    	$pending_projects = Client::where('status',1)->count();
    	$process_projects = Client::where('status',2)->count();
    	$closed_projects = Client::where('status',3)->count();
    	$refused_projects = Client::where('status',4)->count();
    	
        // TO GET MAXIMUM CLOSED LEADS
        
        $names = Client::where('status',3)->get()->groupby('lead_head');
        foreach ($names as $key => $name) {
            $tot_lead[$key] = $name->count();
        }
        $tops = array_keys($tot_lead, max($tot_lead));
        foreach ($tops as $top) {
            $top_names[] = UserLogin::where('id',$top)->pluck('name')->first();
        }

        // TO GET MAXIMUM CLOSED LEADS

        $years = Client::select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))->groupby('year','month')->get();
        
        
        $statuses = Status::get();
        $dates = [['2018-01-01 00:00:00.001','2018-04-01 00:00:00.001'],['2018-04-01 00:00:00.001','2018-07-01 00:00:00.001'],['2018-07-01 00:00:00.001','2018-10-01 00:00:00.001'],['2018-10-01 00:00:00.001','2019-01-01 00:00:00.001']];

        // GENERATE QUARTER PROJECT STATUS
        
        foreach ($statuses as $key => $statuse) {
            foreach ($dates as $keys => $date) {
                $tots_chart[$keys] = Client::where('status',$statuse->id)->whereBetween('created_at',$date)->get()->count();
            }
            $charts[$key] = $tots_chart;
        }

        // GENERATE QUARTER PROJECT STATUS

        // TOTAL PROJECT

        $tot_chart[] = Client::whereBetween('created_at',['2018-01-01 00:00:00.001','2018-04-01 00:00:00.001'])->get()->count();
        $tot_chart[] = Client::whereBetween('created_at',['2018-04-01 00:00:00.001','2018-07-01 00:00:00.001'])->get()->count();
        $tot_chart[] = Client::whereBetween('created_at',['2018-07-01 00:00:00.001','2018-10-01 00:00:00.001'])->get()->count();
        $tot_chart[] = Client::whereBetween('created_at',['2018-10-01 00:00:00.001','2019-01-01 00:00:00.001'])->get()->count();
        
        // TOTAL PROJECTS

        

    	$chartjs = app()->chartjs
        ->name('lineChartTest')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Jan - Mar','Apr - Jun','Jul - Sept','Oct - Dec'])
        ->datasets([
            [
                "label" => "Total Projects",
                'backgroundColor' => "rgba(32, 168, 216, 0.31)",
                'borderColor' => "rgba(32, 168, 216, 0.7)",
                "pointBorderColor" => "rgba(32, 168, 216, 0.7)",
                "pointBackgroundColor" => "rgba(32, 168, 216, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $tot_chart,
            ],
            [
                "label" => "Pending Projects",
                'backgroundColor' => "rgba(23, 131, 169, 0.31)",
                'borderColor' => "rgba(23, 131, 169, 0.7)",
                "pointBorderColor" => "rgba(23, 131, 169, 0.7)",
                "pointBackgroundColor" => "rgba(23, 131, 169, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $charts[0],
            ],
            [
                "label" => "In Process Projects",
                'backgroundColor' => "rgba(255, 193, 7, 0.31)",
                'borderColor' => "rgba(255, 193, 7, 0.7)",
                "pointBorderColor" => "rgba(255, 193, 7, 0.7)",
                "pointBackgroundColor" => "rgba(255, 193, 7, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $charts[1],
            ],
            [
                "label" => "Closed Projects",
                'backgroundColor' => "rgba(77, 189, 116, 0.31)",
                'borderColor' => "rgba(77, 189, 116, 0.7)",
                "pointBorderColor" => "rgba(77, 189, 116, 0.7)",
                "pointBackgroundColor" => "rgba(77, 189, 116, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $charts[2],
            ],
            [
                "label" => "Refused Projects",
                'backgroundColor' => "rgba(248, 108, 107, 0.31)",
                'borderColor' => "rgba(248, 108, 107, 0.7)",
                "pointBorderColor" => "rgba(248, 108, 107, 0.7)",
                "pointBackgroundColor" => "rgba(248, 108, 107, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $charts[3],
            ]
        ])

        ->options([]);

        return view('home', compact('chartjs','total_projects','pending_projects','closed_projects','process_projects','refused_projects','years','top_names'));
    }
}
