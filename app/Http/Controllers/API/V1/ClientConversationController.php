<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Conv;

class ClientConversationController extends Controller
{
    //Add Conversation Medium
    public function createConversation(Request $request){
    	try{
			$inputs = $request->all();
			
			$validator = ( new Conv )->validateConv( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }

            $id = (new Conv)->store($inputs);
            return apiResponseApp(true, 200, lang('Conversation Medium created successfully'));


    	}catch(Exception $e){
			return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }

    //Update Conversation Medium
    public function updateConversation(Request $request){
    	try{
			$inputs = $request->all();
			
			$validator = ( new Conv )->validateConvUpdate( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }

            $id = (new Conv)->store($inputs, $inputs['id']);
            return apiResponseApp(true, 200, lang('Conversation Medium updated successfully'));

    	}catch(Exception $e){
			return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }


    //All Conversation Medium
    public function allConversation(){
    	try{
            $conversation = Conv::get();
            if (count($conversation) != 0) {
            	return apiResponseApp(true, 200, [], null, $conversation);
            }else{
				return apiResponseApp(false, 400, lang('No conversation medium found'));
            }

    	}catch(Exception $e){
			return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }

    //Delete Conversation Medium
    public function deleteConversation(Request $request){
        try{
            $inputs = $request->all();
            
            $validator = ( new Conv )->validateConvDelete( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }

            $id = (new Conv)->deleteAccount($inputs['id']);
            return apiResponseApp(true, 200, lang('Conversation Medium deleted successfully'));

        }catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }
}
