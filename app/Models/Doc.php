<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    protected $fillable = ['status_type'];
    public function edit($id)
    {
        return $this->where('id',$id)->first();
    }

    public function createDoc($client_id, $user_id, $request, $company_id, $doc){
    	$this->company_id= $company_id;
    	$this->user_id= $user_id;
    	$this->client_id= $client_id;
    	$this->status_type= $request->status_type;
    	$this->doc= $doc;
    	dd($this);
    	die();
    }
}
