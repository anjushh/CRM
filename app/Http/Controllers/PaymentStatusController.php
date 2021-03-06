<?php

namespace App\Http\Controllers;

use App\Models\PaymentStatus;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('payment.edit_first');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id = null, $id1 = null)
    {
        $edit_records = PaymentStatus::where('id', $id1)->first();
        return view('payment.status_update',compact('edit_records'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id, $id1 = null)
    {
        $company_id = active_company();
        $user = user_data();
        
        // Payment Status Update
        $pay = $request->all();
        $pay['company_id'] = $company_id;
        $pay['out_amount'] = $request->remain_amt;
        if($request->remain_amt == 0){
            $pay['status'] = 2;    
        }
        else {
            $pay['status'] = 1;   
        }
        $pay['user_id'] = $user->id;
        $pay['payment_id'] = $id1;
        
        PaymentStatus::create($pay);
        return redirect()->route('all_payments');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentStatus  $paymentStatus
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentStatus $paymentStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentStatus  $paymentStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentStatus $paymentStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentStatus  $paymentStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentStatus $paymentStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentStatus  $paymentStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentStatus $paymentStatus)
    {
        //
    }
}
