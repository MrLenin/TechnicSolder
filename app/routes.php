<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::controller('api', 'ApiController');
Route::controller('dashboard', 'DashboardController');
Route::controller('solder', 'SolderController');
Route::post('/user/create', 'UserController@postCreate');
Route::post('/user/delete/{id}', 'UserController@postDelete');
Route::controller('user', 'UserController');
Route::post('/modpack/create', 'ModpackController@postCreate');
Route::post('/modpack/delete/{id}', 'ModpackController@postDelete');
Route::post('/modpack/edit/{id}', 'ModpackController@postEdit');
Route::post('/modpack/addbuild/{id}', 'ModpackController@postAddBuild');
Route::controller('modpack', 'ModpackController');
Route::post('mod/view/{id}', 'ModController@postModify');
Route::post('mod/delete/{id}', 'ModController@postDelete');
Route::post('mod/create', 'ModController@postCreate');
Route::controller('mod', 'ModController');

/**
 * Authentication Routes
 **/
Route::get('/login', 'BaseController@getLogin');
Route::post('/login', 'BaseController@postLogin');
Route::get('/logout', function() {
	Auth::logout();
	return Redirect::to('login')->with('logout','You have been logged out.');
});

Route::get('/', function() {
	return Redirect::to('dashboard');
});

