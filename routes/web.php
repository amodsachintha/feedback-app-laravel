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
    return view('welcome');
});

Route::get('/view/customers/all/unresolved','AppController@viewAllUnresolvedCustomers');
Route::get('/view/customers/all/all','AppController@viewAllCustomers');
Route::get('/view/summary','AppController@showSummary');
Route::get('/view/all','AppController@showSummaryAll');
Route::get('/view/customer','AppController@showCustomerServiceHistory');


Route::get('/check/id','AppController@checkID');


Route::post('/add/customer','AppController@addCustomer');
Route::get('/add/servicerecord','AppController@addServiceRecord');


Route::get('/update/service/visit','AppController@incrementVisit');
Route::get('/update/service/resolve','AppController@setResolved');
