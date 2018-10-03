<?php

namespace App\Http\Controllers;

use App\Models\MsgReminder;
use App\Models\Client;
use App\Models\Notification;
use Illuminate\Http\Request;

class MsgReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id = null)
    {

        try{
            $clients = Client::get();
            $reminders = (new MsgReminder)->msgRemindersData();
            if($id) {
                $edit_records = (new MsgReminder)->edit($id);
                return view('reminder.create',compact('clients','reminders','edit_records'))->with('i', ($request->input('page', 1) - 1) * 10);
            }
            else {
                return view('reminder.create',compact('clients','reminders'))->with('i', ($request->input('page', 1) - 1) * 10);
            }
        }
        catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id = null)
    {
        try{
            $clients = Client::get();
            $reminders = MsgReminder::get();
            $company_id = active_company();
            // To get user_type
            $user = user_data();
            // To get user_type

            $inputs = $request->all();
            $inputs['status'] = ($inputs['status'] == "on") ? 1 : 0;
            $inputs = $inputs + [
                'user_id' =>$user->id,
                'company_id' => $company_id,
            ];

            if($id != null){
                (new MsgReminder)->store($inputs, $id);
                return view('reminder.create',compact('clients','reminders'));
            }
            else {
                $validator = (new MsgReminder)->ValidateRequest($inputs);
                if($validator->fails()) {
                   return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
                }
                (new MsgReminder)->store($inputs);
                return view('reminder.create',compact('clients','reminders'));
            }
        }
        catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MsgReminder  $msgReminder
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $reminders = MsgReminder::get();
            $company_id = active_company();
            $user_id = user_data();
            foreach ($reminders as $reminder){
                if($reminder->rem_date == date('Y-m-d')){
                    (new Notification)->createNotification($reminder, $company_id,$user_id->id);
                }
                else {
                    // return redirect()->back()->with('alert', 'Deleted!');
                }
            }
            return view('reminder.view')->with('alert', 'Deleted!');
        }
        catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MsgReminder  $msgReminder
     * @return \Illuminate\Http\Response
     */
    public function edit(MsgReminder $msgReminder)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MsgReminder  $msgReminder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MsgReminder $msgReminder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MsgReminder  $msgReminder
     * @return \Illuminate\Http\Response
     */
    public function destroy(MsgReminder $msgReminder)
    {
        //
    }
}
