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

Route::middleware('auth:api')->group(function () {
    // routes that need authentication
    
});

Route::post('/add_event', 'EventController@Create');
Route::post('/update_event', 'EventController@Update');
Route::post('/delete_event', 'EventController@Delete');
Route::post('/read_event', 'EventController@Read');
Route::post('/user/register', 'PassportAuth\RegisterController@signUp');
Route::post('/user/verify_partner', 'PassportAuth\RegisterController@verifyNumber');
Route::post('/user/confirm', 'PassportAuth\RegisterController@confirm');
