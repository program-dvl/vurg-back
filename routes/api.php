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
Route::get('email/verify/{id}', 'App\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify');

Route::post('contactus', 'App\Http\Controllers\User\ContactUsController@store');

// Get All Timezones
Route::get('timezones', 'App\Http\Controllers\User\TimezoneController@index');

// Get All Currencies
Route::get('currencies', 'App\Http\Controllers\User\CurrencyController@index');

// Get All Countries with Phone code
Route::get('countries', 'App\Http\Controllers\User\CountryController@index');

// Get All Settings
Route::get('settings', 'App\Http\Controllers\User\SettingsController@index');

Route::middleware(['auth:sanctum'])->group(function () {
    // Route::get('user', 'App\Http\Controllers\User\UserController@index');
    Route::get('email/resend', 'App\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');
    Route::post('otp/send', 'App\Http\Controllers\Auth\VerificationController@sendOTP')->name('verify.otp');
    Route::post('otp/verify', 'App\Http\Controllers\Auth\VerificationController@verifyOTP')->name('verify.otp');

    // User Avatar
    Route::post('upload/avatar', 'App\Http\Controllers\User\UserController@uploadAvatar');
    Route::get('remove/avatar', 'App\Http\Controllers\User\UserController@removeAvatar');

    // Change Username
    Route::post('username/update', 'App\Http\Controllers\User\UserController@changeUsername');

    // Update Profile
    Route::post('profile/update', 'App\Http\Controllers\User\UserController@updateProfile');

    // Get user wallets
    Route::get('wallets', 'App\Http\Controllers\Wallet\WalletController@index');
    
    // Get supported
    Route::get('coins', 'App\Http\Controllers\Wallet\WalletController@allCoins');
    Route::post('logout', 'App\Http\Controllers\Auth\AuthController@logout');
});

Route::get('express', 'App\Http\Controllers\User\UserController@express');