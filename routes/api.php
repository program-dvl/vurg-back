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
Route::post('refresh', 'App\Http\Controllers\Auth\AuthController@refresh');
Route::post('register', 'App\Http\Controllers\Auth\AuthController@register');
Route::get('email/verify/{id}', 'App\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify');

Route::post('contactus', 'App\Http\Controllers\User\ContactUsController@store');

Route::get('get_exchange_rate', 'App\Http\Controllers\Auth\AuthController@getNewExchangeRate');

// Get All Timezones
Route::get('timezones', 'App\Http\Controllers\User\TimezoneController@index');

// Get All Currencies
Route::get('currencies', 'App\Http\Controllers\User\CurrencyController@index');

// Get All Countries with Phone code
Route::get('countries', 'App\Http\Controllers\User\CountryController@index');

Route::middleware(['auth:api', 'lastActivity'])->group(function () {
    // Get All Settings
    Route::get('settings', 'App\Http\Controllers\User\SettingsController@index');

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
    Route::get('profile/{id}', 'App\Http\Controllers\User\UserController@getProfile');

    // Get Offers
    Route::post('offers', 'App\Http\Controllers\Offer\OffersController@index');
    // Get All Offers
    Route::post('all/offers', 'App\Http\Controllers\Offer\OffersController@getAllByOrSellOffers');
    // save offers
    Route::post('create/offer', 'App\Http\Controllers\Offer\OffersController@createOffer');
    // save offers
    Route::post('update/offer', 'App\Http\Controllers\Offer\OffersController@createOffer');

    
    // Get Payment methods
    Route::get('offer/paymentMethod', 'App\Http\Controllers\Offer\OffersController@getPaymentMethods');

    // Get Offer Tags
    Route::get('offer/tags', 'App\Http\Controllers\Offer\OffersController@getOfferTags');
    
    // View Offer
    Route::get('offer/{id}', 'App\Http\Controllers\Offer\OffersController@viewOffer');
    // CHange Offer Status
    Route::post('offer/change/status', 'App\Http\Controllers\Offer\OffersController@changeOfferStatus');
    // View Offer
    Route::post('offer/feedback/{id}', 'App\Http\Controllers\Offer\OffersController@viewFeedbackByOfferId');
    //Add or Remove in Favourite
    Route::post('offer/add/favourite', 'App\Http\Controllers\Offer\OffersController@addToFavourite');
    Route::post('offer/remove/favourite', 'App\Http\Controllers\Offer\OffersController@removeFavourite');

    // Get Feedback
    Route::post('feedback', 'App\Http\Controllers\Offer\OfferTradeFeedbackController@index');

    // Add Feedback
    Route::post('add/feedback', 'App\Http\Controllers\Offer\OfferTradeFeedbackController@addFeedback');

    // Get user wallets
    Route::get('wallets', 'App\Http\Controllers\Wallet\WalletController@index');

    // Get coin address
    Route::get('address/{coinId}', 'App\Http\Controllers\Wallet\WalletController@getAddress');
    
    // Get supported
    Route::get('coins', 'App\Http\Controllers\Wallet\WalletController@allCoins');
    Route::post('logout', 'App\Http\Controllers\Auth\AuthController@logout');

    Route::get('coin-rate/{currency}/{amount}', 'App\Http\Controllers\Wallet\WalletController@getExchangeRate');

    Route::get('transactions/{coinId}', 'App\Http\Controllers\Wallet\WalletController@getTransactions');

    Route::post('trade', 'App\Http\Controllers\Trade\TradeController@createTrade');
    Route::get('trade/{tradeId}/cancel', 'App\Http\Controllers\Trade\TradeController@cancelTrade');
    Route::get('trade/{tradeId}/accept', 'App\Http\Controllers\Trade\TradeController@acceptPayment');
    Route::get('trade/{tradeId}/receive', 'App\Http\Controllers\Trade\TradeController@receivePayment');
    Route::get('trade/{tradeId}', 'App\Http\Controllers\Trade\TradeController@tradeDetails');

    Route::post('pre-transaction-details', 'App\Http\Controllers\Transaction\TransactionController@getPreTransactionDetails');
    Route::post('convert-currency', 'App\Http\Controllers\Transaction\TransactionController@getConvertedCurrency');
    Route::post('send-coin', 'App\Http\Controllers\Transaction\TransactionController@sendCointoAddress');


    //Get Notification UnreadCount
    Route::get('notification/unread-count', 'App\Http\Controllers\Notification\NotificationController@getUnreadNotificationCount');

    //Get All Notifications
    Route::post('get/notification', 'App\Http\Controllers\Notification\NotificationController@getAllNotifications');

    //Make All notifications to read
    Route::get('notification/mark-as-read', 'App\Http\Controllers\Notification\NotificationController@markAsReadNotifications');
    
});
Route::get('express', 'App\Http\Controllers\User\UserController@express');
// Route::get('wallet', 'App\Http\Controllers\User\UserController@add');
// Route::get('express', 'App\Http\Controllers\User\UserController@express');
