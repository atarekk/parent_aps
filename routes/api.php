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

Route::prefix('v1')->group(function () {
    Route::post("login",'API\Auth\LoginController@login');
     Route::group(['middleware' => 'auth:api'], function(){
    Route::get("users",'API\UserController@getAllUsers');

        });
});
