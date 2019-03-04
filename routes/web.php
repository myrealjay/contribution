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
    return view('landing');
});

Route::get('/about', function () {
    return view('about');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/send/email', 'HomeController@mail');

Route::get('/confirm', 'AdminController@confirm');

Route::post('/verifynow', 'AdminController@verifynow');

Route::post('/reg_scheme', 'AdminController@reg_scheme');

Route::get('/new_scheme', 'AdminController@new_scheme');

Route::get('/MyScheme', 'AdminController@MyScheme');

Route::get('/AddMembers', 'AdminController@AddMembers');

Route::post('/RegMember', 'AdminController@RegMember');

Route::post('/chk_scheme', 'AdminController@chk_scheme');

Route::post('/join', 'AdminController@join');

Route::post('/add_mem', 'AdminController@add_mem');

Route::post('/view_members', 'AdminController@view_members');


#Auth::routes();

#Route::get('/home', 'HomeController@index');