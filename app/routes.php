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
Route::post('/modpack/addbuild/{id}', array('as' => 'modpack.addbuild', 'uses' => 'ModpackController@postAddBuild'));
Route::get('/modpack/{id}/delete', array('as' => 'modpack.delete', 'uses' => 'ModpackController@delete'));
Route::resource('modpack', 'ModpackController');
Route::get('/mod/{id}/delete', array('as' => 'mod.delete', 'uses' => 'ModController@delete'));
Route::resource('mod', 'ModController');
Route::resource('mod.version', 'VersionController', array('only' => array('store', 'destroy', 'update')));
Route::get('/modpack/build/{id}/delete', array('as' => 'modpack.build.delete', 'uses' => 'BuildController@delete'));
Route::post('/modpack/build/modify/{action}', array('as' => 'modpack.build.modify', 'uses' => 'BuildController@modify'));
Route::resource('modpack.build', 'BuildController', array('only' => array('create', 'edit', 'destroy', 'store')));

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

