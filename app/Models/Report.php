<?php

namespace App\Models;
use DB;
use App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //For Web --- Anju

    public function clientFilter($clients, $client_id) {
    	return Client::join('statuses', 'statuses.id' , '=', 'clients.status')->join('user_logins','user_logins.id','=','clients.lead_head')->select('clients.id as id','clients.status as status','clients.created_at as created_at','clients.name as client_name', 'statuses.status_type as project_status','user_logins.name as lead_name')->where('clients.id',$client_id);
    }
}
