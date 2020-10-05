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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(array('prefix' => '/v1'), function() {
  
    Route::post('register', 'App\Http\Controllers\UserController@register');
    Route::post('login', 'App\Http\Controllers\UserController@login');
    Route::apiResource('bank', 'App\Http\Controllers\BankController')->middleware('client');
    Route::apiResource('user', 'App\Http\Controllers\UserController')->middleware('client');
    Route::apiResource('news', 'App\Http\Controllers\NewsController')->middleware('client');
    Route::apiResource('visit', 'App\Http\Controllers\VisitController')->middleware('client');
   
});

