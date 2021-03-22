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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login', 'App\Http\Controllers\Auth\AuthController@login');
Route::post('register', 'App\Http\Controllers\Auth\AuthController@register');
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('email/verify/{id}', 'App\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify');
    Route::get('email/resend', 'App\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');
    Route::post('otp/send', 'App\Http\Controllers\Auth\VerificationController@sendOTP')->name('verify.otp');
    Route::post('otp/verify', 'App\Http\Controllers\Auth\VerificationController@verifyOTP')->name('verify.otp');
});