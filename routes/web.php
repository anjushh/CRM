<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/remind', 'MsgReminderController@remind');


// Login Routes
Route::get('/login', 'LoginController@login')->name('login.login');
Route::get('/register', 'LoginController@register')->name('login.register');
Route::post('/store','LoginController@store')->name('login.store');
Route::post('/login','LoginController@loginstore')->name('login.loginstore');



Route::group(['middleware' => 'login'], function (){
	Route::get('/dashboard', 'ChartController@index')->name('dashboard');

	Route::get('/dummy', function () {
	    return view('admin.dummy');
	});

	// Login Routes
	Route::get('/logout','LoginController@logout')->name('login.logout');
	// Login Routes

	// User Type Routes
	Route::get('/user_type/create','UserTypeController@create')->name('user_type.create');
	Route::post('/user_type/store','UserTypeController@store')->name('user_type.store');
	Route::get('/user_type/show', 'UserTypeController@show')->name('user_type.show');
	Route::get('/user_type/edit/{id}','UserTypeController@edit')->name('user_type.edit');
	Route::patch('/user_type/update/{id}','UserTypeController@update')->name('user_type.update');

	// User Type Routes


	// Company Routes
	Route::get('/company/create','CompanyController@create')->name('company.create');
	Route::post('/company/store','CompanyController@store')->name('company.store');
	Route::get('/company/edit/{id}','CompanyController@edit')->name('company.edit');
	Route::patch('/company/update/{id}','CompanyController@update')->name('company.update');
	// Company Routes

	// User Login Routes
	Route::get('/user/create','UserLoginController@create')->name('user.create');
	Route::post('/user/store','UserLoginController@store')->name('user.store');
	Route::get('/user/edit/{id}','UserLoginController@edit')->name('user.edit');
	Route::patch('/user/update/{id}','UserLoginController@store')->name('user.update');
	// User Login Routes

	// Service Type Master
	Route::get('/service_type/create','ServiceTypeController@create')->name('service_type.create');
	Route::get('/service_type/create/{id}','ServiceTypeController@create')->name('service_type.edit');
	Route::post('/service_type/store','ServiceTypeController@store')->name('service_type.store');
	Route::patch('/service_type/store/{id}','ServiceTypeController@store')->name('service_type.update');
	Route::get('/service_type/show', 'ServiceTypeController@show')->name('service_type.show');
	// Service Type Master

	// Services Routes

	Route::get('/services/create', 'ServiceController@create')->name('services.create');
	Route::get('/services/create/{id}','ServiceController@create')->name('services.edit');
	Route::post('/services/store','ServiceController@store')->name('services.store');
	Route::patch('/services/store/{id}','ServiceController@store')->name('services.update');
	// Services Routes

	// Conversation Routes
	Route::get('/conv/create', 'ConvController@create')->name('conv_type.create');
	Route::get('/conv/create/{id}','ConvController@create')->name('conv_type.edit');
	Route::post('/conv/store','ConvController@store')->name('conv_type.store');
	Route::patch('/conv/store/{id}','ConvController@store')->name('conv_type.update');
	// Conversation Routes

	// Status Routes
	Route::get('/status/create', 'StatusController@create')->name('status.create');
	Route::get('/status/create/{id}','StatusController@create')->name('status.edit');
	Route::post('/status/store','StatusController@store')->name('status.store');
	Route::patch('/status/store/{id}','StatusController@store')->name('status.update');
	// Status Routes

	// Client Routes
	Route::get('/client/create', 'ClientController@create')->name('client.create');
	Route::get('/client/create/{id}','ClientController@create')->name('client.edit');
	Route::post('/client/store','ClientController@store')->name('client.store');
	Route::patch('/client/store/{id}','ClientController@store')->name('client.update');
	Route::get('/client/price/{id}','ClientController@get_price')->name('client.price');
	// Client Routes

	// Lead Assignment Routes
	Route::get('/lead-assign', 'LeadAssignmentController@index')->name('all.leads');
	// Lead Assignment Routes

	// Payment Module Routes
	Route::get('/payments', 'PaymentController@create')->name('all_payments');
	Route::get('/payment-update/{id}', 'PaymentController@create')->name('payment.edit');
	Route::patch('/payment-update/store/{id}', 'PaymentController@store')->name('payment.store');
	// Payment Module Routes

	// Status Update Route
	Route::get('/status-update', 'StatusUpdateController@create')->name('status_update.update');
	Route::get('/status-update/{id}/{id1}', 'StatusUpdateController@create')->name('status_update.edit');
	Route::post('/status-update/store', 'StatusUpdateController@store')->name('status_update.store');
	Route::patch('/status-update/store/{id}/{id1}', 'StatusUpdateController@store')->name('status_update.update');
	// Status Update Route


	// Payment Status Update Routes
	Route::get('/payment-update/status/{id}/{id1}', 'PaymentStatusController@create')->name('payment_status.update');
	Route::post('/payment-update/status_update/{id}/{id1}', 'PaymentStatusController@store')->name('payment_status.store');
	Route::get('/payment-update/status/{id}', 'PaymentStatusController@index')->name('payment_status.index');
	// Payment Status Update Routes

	// Reminder Routes
	Route::get('/call-reminder','MsgReminderController@show')->name('reminder.show');
	Route::get('/reminder/create','MsgReminderController@create')->name('reminder.create');
	Route::get('/reminder/edit/{id}','MsgReminderController@create')->name('reminder.edit');
	Route::post('/reminder/store','MsgReminderController@store')->name('reminder.store');
	Route::patch('/reminder/store/{id}','MsgReminderController@store')->name('reminder.update');
	Route::get('/reminder/delete/{id}','MsgReminderController@destroy')->name('reminder.delete');


	// Notifications routes
	Route::get('/notification/read/{id}','NotificationController@read')->name('noti.read');
	Route::get('/notifications','NotificationController@index')->name('all_noti');


	Route::get('/send/email', 'ClientController@mail');

	// Client Reports Routes
	Route::get('/client-reports', 'ReportController@index')->name('client.reports');
	Route::get('/client-reports/{client_id}/{status}/{from_date}/{to_date}', 'ReportController@client_data')->name('client.data');
	Route::get('/pay/{id}', 'ReportController@pay_status')->name('get_payment');

	// Lead Reports Routes
	Route::get('/lead-reports', 'ReportController@lead')->name('lead');
	Route::get('/lead-reports/{id}/{from_date}/{to_date}', 'ReportController@lead_data')->name('lead.data');

	//Profile Routes
	Route::get('/profile', 'ProfileController@index')->name('profile');

});