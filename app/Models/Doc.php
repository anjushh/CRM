<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    protected $fillable = ['status_type', 'client_id', 'user_id', 'company_id', 'doc'];
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
        $this->save();
    	// dd($this);
    	// die();
    }

    //For App --- Khushboo
    public function store($input, $id = null)
     {
         if ($id) {
             return $this->find($id)->update($input);
         } else {
             return $this->create($input)->id;
         }
     }  
}
