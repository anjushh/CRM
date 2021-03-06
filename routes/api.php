<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Registration -- Khushboo
Route::any('/v1/register', ['as' => 'register', 'uses' => 'API\V1\UserController@create']);
//User Types -- Khushboo
Route::any('/v1/user-types', ['as' => 'user-types', 'uses' => 'API\V1\UserController@userType']);

/*APIAuthenticate*/
Route::group(array('middleware' => 'auth.api'), function () {
	/*Login*/
	Route::any('v1/login', ['as' => 'login','uses' => 'API\V1\AuthController@index']);
	/*Login*/
	Route::any('v1/user-list', ['as' => 'login','uses' => 'API\V1\UserController@userList']);
	/*Login*/
	Route::any('v1/user-profile', ['as' => 'user-profile','uses' => 'API\V1\UserController@userProfile']);
	/*Edit Profile*/
	Route::any('v1/edit-profile', ['as' => 'edit-profile','uses' => 'API\V1\UserController@editProfile']);
	/*Delete Profile*/
	Route::any('v1/delete-profile', ['as' => 'delete-profile','uses' => 'API\V1\UserController@deleteUser']);
	/*Create Service Type*/
	Route::any('v1/create-servicetype', ['as' => 'create-servicetype','uses' => 'API\V1\ServiceTypeContoller@createServiceType']);
	/*Edit Service Type*/
	Route::any('v1/edit-servicetype', ['as' => 'edit-servicetype','uses' => 'API\V1\ServiceTypeContoller@editServiceType']);
	/*Create Company*/
	Route::any('v1/create-company', ['as' => 'create-company','uses' => 'API\V1\CompanyController@createCompany']);
	/*Route Company*/
	Route::any('v1/edit-company', ['as' => 'edit-company','uses' => 'API\V1\CompanyController@editCompany']);
	/*Route Company*/
	Route::any('v1/list-company', ['as' => 'list-company','uses' => 'API\V1\CompanyController@companyList']);
	/*Route Company*/
	Route::any('v1/delete-company', ['as' => 'delete-company','uses' => 'API\V1\CompanyController@deleteCompany']);
	/*Route Company*/
	Route::any('v1/delete-servicetype', ['as' => 'delete-servicetype','uses' => 'API\V1\ServiceTypeContoller@deleteService']);
	/*Route Company*/
	Route::any('v1/all-services-type', ['as' => 'all-services-type','uses' => 'API\V1\ServiceTypeContoller@serviceList']);
	/*Route Company*/
	Route::any('v1/other-user-profile', ['as' => 'other-user-profile','uses' => 'API\V1\UserController@userProfileAll']);
	/*Route Company*/
	Route::any('v1/create-service', ['as' => 'create-service','uses' => 'API\V1\ServiceController@createService']);
	/*Route Company*/
	Route::any('v1/edit-service', ['as' => 'edit-service','uses' => 'API\V1\ServiceController@editService']);
	/*Route Company*/
	Route::any('v1/delete-service', ['as' => 'delete-service','uses' => 'API\V1\ServiceController@deleteService']);
	/*Route Company*/
	Route::any('v1/all-service', ['as' => 'all-service','uses' => 'API\V1\ServiceController@allService']);
	/*Route Company*/
	Route::any('v1/all-service-status', ['as' => 'all-service-status','uses' => 'API\V1\ServiceController@allServiceUpdated']);
	/*Route Company*/
	Route::any('v1/create-conv-medium', ['as' => 'create-conv-medium','uses' => 'API\V1\ClientConversationController@createConversation']);
	/*Route Company*/
	Route::any('v1/update-conv-medium', ['as' => 'update-conv-medium','uses' => 'API\V1\ClientConversationController@updateConversation']);
	/*Route Company*/
	Route::any('v1/all-conv-medium', ['as' => 'all-conv-medium','uses' => 'API\V1\ClientConversationController@allConversation']);
	/*Route Company*/
	Route::any('v1/delete-conv-medium', ['as' => 'delete-conv-medium','uses' => 'API\V1\ClientConversationController@deleteConversation']);
	/*Route Company*/
	Route::any('v1/create-status', ['as' => 'create-status','uses' => 'API\V1\ClientStatusController@createStatus']);
	/*Route Company*/

	Route::any('v1/update-status', ['as' => 'update-status','uses' => 'API\V1\ClientStatusController@updateStatus']);
	/*Route Company*/
	Route::any('v1/all-status', ['as' => 'all-status','uses' => 'API\V1\ClientStatusController@allStatus']);
	/*Route Company*/
	Route::any('v1/delete-status', ['as' => 'delete-status','uses' => 'API\V1\ClientStatusController@deleteStatus']);
	/*Route Company*/
	Route::any('v1/create-client', ['as' => 'create-client','uses' => 'API\V1\ClientController@createClient']);
	/*Route Company*/
	Route::any('v1/all-client', ['as' => 'all-client','uses' => 'API\V1\ClientController@clientList']);
	/*Route Company*/
	Route::any('v1/edit-client', ['as' => 'edit-client','uses' => 'API\V1\ClientController@editClient']);
	/*Route Company*/
	Route::any('v1/update-status-client', ['as' => 'update-status-client','uses' => 'API\V1\ClientController@updateStatus']);
	/*Route Company*/
	Route::any('v1/client-profile', ['as' => 'client-profile','uses' => 'API\V1\ClientController@clientProfile']);
	/*All Payment*/
	Route::any('v1/all-payment', ['as' => 'all-payment','uses' => 'API\V1\PaymentController@allPayment']);
	/*edit Payment*/
	Route::any('v1/edit-payment', ['as' => 'edit-payment','uses' => 'API\V1\PaymentController@editPayment']);
	/*update Payment*/
	Route::any('v1/update-payment', ['as' => 'update-payment','uses' => 'API\V1\PaymentController@updatePayment']);
	/*update Payment*/
	Route::any('v1/all-client-report', ['as' => 'all-client-report','uses' => 'API\V1\ReportingController@allClientReports']);
	/*update Payment*/
	Route::any('v1/all-client-report-byname', ['as' => 'all-client-report-byname','uses' => 'API\V1\ReportingController@allClientReportsName']);
	/*update Payment*/
	Route::any('v1/all-client-report-bystatus', ['as' => 'all-client-report-bystatus','uses' => 'API\V1\ReportingController@allClientReportsStatus']);
	/*update Payment*/
	Route::any('v1/all-client-name', ['as' => 'all-client-name','uses' => 'API\V1\ClientController@clientNameList']);
	Route::any('v1/all-lead-name', ['as' => 'all-lead-name','uses' => 'API\V1\UserController@leadName']);
	/*update Payment*/
	Route::any('v1/all-lead-report-byname', ['as' => 'all-lead-report-byname','uses' => 'API\V1\ReportingController@allLeadReportsName']);
	Route::any('v1/all-lead-report-bydate', ['as' => 'all-lead-report-bydate','uses' => 'API\V1\ReportingController@allLeadReportsByDate']);
	Route::any('v1/all-client-report-bydate', ['as' => 'all-client-report-bydate','uses' => 'API\V1\ReportingController@allClientReportsByOnlyDate']);
	Route::any('v1/all-client-report-bydatename', ['as' => 'all-client-report-bydatename','uses' => 'API\V1\ReportingController@allClientReportsByDateName']);
	Route::any('v1/all-client-report-bydatestatus', ['as' => 'all-client-report-bydatestatus','uses' => 'API\V1\ReportingController@allClientReportsByDateStatus']);
	Route::any('v1/add-device', ['as' => 'add-device','uses' => 'API\V1\UserController@addDevice']);
	Route::any('v1/add-reminder', ['as' => 'add-reminder','uses' => 'API\V1\MessageReminderController@createReminder']);
	Route::any('v1/reminders-list', ['as' => 'reminders-list','uses' => 'API\V1\MessageReminderController@remindersList']);
});