<?php

namespace App\Http\Controllers;
use App\Models\Payment;
use App\Models\PaymentStatus;
use App\Models\Msgreminder;
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
        $inputs = $request->all();
        if($id != null && $id1 == null) {
            $validator = (new PaymentStatus)->ValidateData($inputs);
            if( $validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            // Reminder To Add
            // First Installment
            if($request->inst_date_1 != null){
                $remarks = 'Today is the First Installment Date this Project';
                (new Msgreminder)->ins_rem_Update($company_id,$user->id,$request,$request->inst_date_1,$remarks);

                // Second Installment
                if($request->inst_date_2 != null){
                    $remarks = 'Today is the Second Installment Date this Project';
                    (new Msgreminder)->ins_rem_Update($company_id,$user->id,$request,$request->inst_date_2,$remarks);

                    // Third Installment
                    if($request->inst_date_3 != null){
                        $remarks = 'Today is the Third Installment Date this Project';
                        (new Msgreminder)->ins_rem_Update($company_id,$user->id,$request,$request->inst_date_3,$remarks);
                    }
                }
                
            }
            

            // Payment Status Update
            (new PaymentStatus)->PaymentStatusUpdate($company_id,$request->client_id,$user->id,$request,$id);
            // Payment Status Update

            $create_records = Payment::paginate(10);
            Payment::find($id)->update($request->all());
            return redirect()->back()->with('success','Data Saved Successfully');

        }
        
        $create_records = Payment::paginate(10);
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
