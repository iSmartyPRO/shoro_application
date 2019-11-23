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

/*Route::get('/', function () {
    return view('welcome');
});*/

//Route::get('/testController', 'testController@index');

Route::get('/simpletest',function(){
    return 'Test';
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/date/{date}','HomeController@datedetail');
Route::get('/details/{id}','HomeController@detailById');
Route::get('/report/','HomeController@report');
Route::get('/help/','HomeController@help');
Route::get('/test','HomeController@test');


Route::get('/users/{user}',  ['as' => 'users.edit', 'uses' => 'UserController@edit']);
Route::patch('/users/{user}/update',  ['as' => 'users.update', 'uses' => 'UserController@update']);