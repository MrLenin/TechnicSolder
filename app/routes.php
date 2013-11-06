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
Route::get('mod/{id}/delete', array('as' => 'mod.delete', 'uses' => 'ModController@delete'));
//Route::get('mod/{id}/versions', array('as' => 'mod.versions', 'uses' => 'ModController@versions'));
//Route::post('mod/addversion', 'ModController@addVersion');
Route::resource('mod', 'ModController');
Route::resource('mod.version', 'ModVersionController', array('only' => array('store', 'destroy', 'update')));

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

