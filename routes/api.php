<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::group(array('prefix' => '/v1'), function() {
  
    Route::post('register', 'App\Http\Controllers\UserController@register');
    Route::post('login', 'App\Http\Controllers\UserController@login');
    Route::apiResource('bank', 'App\Http\Controllers\BankController')->middleware('client');
    Route::apiResource('user', 'App\Http\Controllers\UserController')->middleware('client');
    Route::apiResource('bank/{bank_id}/news', 'App\Http\Controllers\NewsController')->middleware('client');
    Route::apiResource('visit', 'App\Http\Controllers\VisitController')->middleware('client');

   
});

Route::any('{catchall}', function() {
    return Response::json(["message"=>"Route not found"],404); 
  })->where('catchall', '.*');