<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MsgReminder;
use App\Models\Company;

class MessageReminderController extends Controller
{
    // Create reminder 
    public function createReminder(Request $request){
    	try{
    		$inputs = $request->all();
			
			$validator = ( new MsgReminder )->ValidateRequestApp( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }

            $company_id = Company::where('status', 1)->value('id');
          	$inputs = $inputs + [
          							'user_id' => \Auth::User()->id,
          							'company_id' => $company_id
          	];
            $id = (new MsgReminder)->store($inputs);
            return apiResponseApp(true, 200, lang('Reminder set successfully'));


    	}catch(Exception $e){
			return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }

    // Reminders List
    public function remindersList(Request $request){
    	try{
    		$reminders = MsgReminder::get();
    		if (count($reminders) != 0) {
            		return apiResponseApp(true, 200, null, null, $reminders);
    		}else{
            		return apiResponseApp(false, 400, 'No reminders set');
            }


    	}catch(Exception $e){
			return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }
}
