<?php
	function active_company()
    {
        return App\Models\Company::where('status',1)->pluck('id')->first();
    }
    function user_type() {
    	$user = Session::get('userdata');
    	return $user->user_type;
    }
    function user_data(){
    	$user = Session::get('userdata');
    	return $user;
    }
?>