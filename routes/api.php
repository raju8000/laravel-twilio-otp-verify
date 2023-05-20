<?php

use Illuminate\Http\Request;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('v1')->namespace('App\Http\Controllers')->group(function () {


    //Sign up 
    Route::post('/sendOtp', 'SignupController@sendOtp');
    Route::post('verifyOtp', 'SignupController@verifyOtp');

    // After signup Email Verify

    //Forgot Password
    // Route::post('forgot-password', 'AuthenticationController@forgot_password');
    // Route::post('reset-password/{password_token?}', 'AuthenticationController@update_password');
    // Route::post('check-balance/', 'AuthenticationController@check_balance');
    // Route::post('crete-token/{code?}', 'AuthenticationController@create_token');
    // Route::post('create-password', 'AuthenticationController@change_password');
    //Route::get('link-expiry', 'AuthenticationController@link_expiry');


});
