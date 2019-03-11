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

Route::post('register', 'UserController@register');

Route::post('login', 'UserController@authenticate');



Route::get('open', 'DataController@open');

Route::group(['middleware' => ['jwt.verify']], function() {
	Route::get('user', 'UserController@getAuthenticatedUser');
	Route::get('closed', 'DataController@closed');
	
	Route::post('new_scheme', 'UserController@new_scheme');

	Route::post('verifynow', 'UserController@verifynow');

	Route::get('/MyScheme', 'UserController@MyScheme');
	Route::get('/schemeMembers/{scheme}', 'UserController@getSchemeMembers');
	Route::get('/checkJoined/{scheme}', 'UserController@checkJoined');
	Route::get('/activeMembers/{scheme}', 'UserController@getActiveMembers');

	Route::post('RegMember', 'UserController@RegMember');
	Route::post('pay', 'UserController@pay');

	Route::post('/join', 'UserController@join');

	Route::post('/chk_scheme', 'UserController@chk_scheme');

	Route::post('view_members', 'UserController@view_members');
});
