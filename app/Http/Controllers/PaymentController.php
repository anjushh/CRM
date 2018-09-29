<?php

namespace App\Http\Controllers;
use App\Models\Payment;
use App\Models\PaymentStatus;

use DB;
use Validator;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id = null)
    {   
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id = null)
    {
        if($id != null){
            $edit_records = Payment::where('id',$id)->first();
            return view('payment.edit',compact('edit_records'))->with('i', ($request->input('page', 1) - 1) * 10);    
        }
        $create_records = Payment::get();
        return view('payment.payment',compact('statuses','create_records'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id = null, $id1 = null)
    {

        $company_id = active_company();
        $user = user_data();
        
        // Payment Status Update
        $pay = new PaymentStatus;
        $pay->company_id = $company_id;
        $pay->client_id = $request->client_id;
        $pay->payment_id = $id;
        $pay->user_id = $user->id;
        $pay->amt_rcvd = null;
        $pay->out_amount = $request->out_amount;
        $pay->status = null;
        $pay->pay_date = null;
        $pay->save();
        // Payment Status Update


        $create_records = Payment::get();
        Payment::find($id)->update($request->all());
        return redirect()->route('all_payments',compact('statuses','create_records'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
