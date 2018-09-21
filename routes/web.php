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

Route::get('/', function () {
    return view('layouts.dashboard');
});

Route::get('/dummy', function () {
    return view('admin.dummy');
});



Route::get('/dashboard', 'HomeController@index')->name('home');


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


// Login Routes
Route::get('/login', 'LoginController@login')->name('login.login');
Route::get('/register', 'LoginController@register')->name('login.register');
Route::post('/store','LoginController@store')->name('login.store');
Route::post('/login','LoginController@loginstore')->name('login.loginstore');
Route::get('/logout','LoginController@logout')->name('login.logout');

Route::group(['middleware' => 'login'], function () {
	
}
// Login Routes