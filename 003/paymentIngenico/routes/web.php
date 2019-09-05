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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', 'PaymentController@index');

Route::match(['get', 'post'],'/add_transaction', 'PaymentController@addNewNoteTransaction');

Route::post('add/transaction', 'PaymentController@addSelectedTransaction');