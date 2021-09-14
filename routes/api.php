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

Route::middleware(['auth:api', 'lastActivity'])->group(function () {
    // Route::get('user', 'App\Http\Controllers\User\UserController@index');
    Route::get('email/resend', 'App\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');
    Route::post('otp/send', 'App\Http\Controllers\Auth\VerificationController@sendOTP')->name('verify.otp');
    Route::post('otp/verify', 'App\Http\Controllers\Auth\VerificationController@verifyOTP')->name('verify.otp');
    Route::post('change/password', 'App\Http\Controllers\User\UserController@changePassword');

    // User Avatar
    Route::post('upload/avatar', 'App\Http\Controllers\User\UserController@uploadAvatar');
    Route::get('remove/avatar', 'App\Http\Controllers\User\UserController@removeAvatar');

    // Change Username
    Route::post('username/update', 'App\Http\Controllers\User\UserController@changeUsername');

    // Update Profile
    Route::post('profile/update', 'App\Http\Controllers\User\UserController@updateProfile');
    // Get Profile
    Route::get('profile', 'App\Http\Controllers\User\UserController@getProfile');

    // Get Offers
    Route::post('offers', 'App\Http\Controllers\Offer\OffersController@index');
    // save offers
    Route::post('create/offer', 'App\Http\Controllers\Offer\OffersController@createOffer');
    // save offers
    Route::post('update/offer', 'App\Http\Controllers\Offer\OffersController@createOffer');
    // View Offer
    Route::get('offer/{id}', 'App\Http\Controllers\Offer\OffersController@viewOffer');
    // CHange Offer Status
    Route::post('offer/change/status', 'App\Http\Controllers\Offer\OffersController@changeOfferStatus');
    // View Offer
    Route::get('offer/feedback/{id}', 'App\Http\Controllers\Offer\OffersController@viewFeedbackByOfferId');

    // Get Feedback
    Route::post('feedback', 'App\Http\Controllers\Offer\OfferTradeFeedbackController@index');

    // Get Offer Tags
    Route::get('offer/tags', 'App\Http\Controllers\Offer\OffersController@getOfferTags');

    // Get Payment methods
    Route::get('offer/paymentMethod', 'App\Http\Controllers\Offer\OffersController@getPaymentMethods');

    // Get user wallets
    Route::get('wallets', 'App\Http\Controllers\Wallet\WalletController@index');

    // Get coin address
    Route::get('address/{coinId}', 'App\Http\Controllers\Wallet\WalletController@getAddress');
    
    // Get supported
    Route::get('coins', 'App\Http\Controllers\Wallet\WalletController@allCoins');
    Route::post('logout', 'App\Http\Controllers\Auth\AuthController@logout');
    
});
Route::get('express', 'App\Http\Controllers\User\UserController@express');
// Route::get('wallet', 'App\Http\Controllers\User\UserController@add');
// Route::get('express', 'App\Http\Controllers\User\UserController@express');
