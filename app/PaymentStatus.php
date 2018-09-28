<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    protected $fillable = ['client_id','company_id','user_id','out_amount','status','pay_date','amt_rcvd','status','payment_id'];
    
    public function edit($id)
    {
        return $this->where('id',$id)->first();
    }
}
