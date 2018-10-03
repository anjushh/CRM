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

    // For Web --- Anju
    function notification(){
        $fields = [
            'notifications.id as id',
            'notifications.client_id as client_id',
            'notifications.remarks as remarks',
            'notifications.user_id as user_id',
            'notifications.rem_date as rem_date',
            'notifications.read_status as read_status',
            'c.name as client_name',
        ];
        $notifications = DB::table('notifications')->where('rem_date',date('Y-m-d'))->join('clients as c', 'c.id', '=', 'notifications.client_id')->get($fields);
        return $notifications;
    }
?>