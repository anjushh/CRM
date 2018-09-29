<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Status;

class ClientStatusController extends Controller
{
    //Add Status
    public function createStatus(Request $request){
    	try{
			$inputs = $request->all();
			
			$validator = ( new Status )->validateStatus( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }

            $id = (new Status)->store($inputs);
            return apiResponseApp(true, 200, lang('Status created successfully'));


    	}catch(Exception $e){
			return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }

    //Update Status
    public function updateStatus(Request $request){
    	try{
			$inputs = $request->all();
			
			$validator = ( new Status )->validateStatusUpdate( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }

            $id = (new Status)->store($inputs, $inputs['id']);
            return apiResponseApp(true, 200, lang('Status updated successfully'));

    	}catch(Exception $e){
			return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }


    //All Status
    public function allStatus(){
    	try{
            $status = Status::get();
            if (count($status) != 0) {
            	return apiResponseApp(true, 200, [], null, $status);
            }else{
				return apiResponseApp(false, 400, lang('No status found'));
            }

    	}catch(Exception $e){
			return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }

    //Delete Status
    public function deleteStatus(Request $request){
        try{
            $inputs = $request->all();
            
            $validator = ( new Status )->validateStatusDelete( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }

            $id = (new Status)->deleteAccount($inputs['id']);
            return apiResponseApp(true, 200, lang('Status deleted successfully'));

        }catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }
}
