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
});