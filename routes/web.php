<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\Admin\UserController;

/*
 * Global Routes
 * Routes that are used between both frontend users and admin.
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Two factor auth rputes
Route::get('verify', 'Auth\TwoFactorController@index')->name('verify.index’');
Route::get('verify/resend', 'Auth\TwoFactorController@resend')->name('verify.resend');
Route::resource('verify', 'Auth\TwoFactorController')->only(['index', 'store']);


Route::group(['namespace' => 'Auth\Admin'], function () {
    Route::post('save/save', [UserController::class, 'save'])->name('user.save');
});

// Admin Routes
Route::group(['middleware' => config('access.users.super_admin'), 'prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Auth\Admin'], function () {
    Route::resource('user', 'UserController');

    Route::get('confirm/{user}', 'UserConfirmationController@confirm')->name('user.confirm');
    Route::get('unconfirm/{user}', 'UserConfirmationController@unconfirm')->name('user.unconfirm');

    Route::get('active/{user}', 'UserActivationController@confirm')->name('user.active');
    Route::get('unactive/{user}', 'UserActivationController@unactivate')->name('user.unactive');

    Route::get('user/payment/withdraw/requests', 'PaymentRequestController@withdrawRequests')->name('payment.withdraw.requests');
    Route::get('user/payment/withdraw/request/accept', 'PaymentRequestController@withdrawRequestAction')->name('payment.withdraw.request.action');

});

// Customer Routes
Route::group(['middleware' => config('access.users.customer_role'), 'prefix' => 'user', 'as' => 'user.', 'namespace' => 'Auth'], function () {
    // Route::group(['middleware' => [config('access.users.customer_role'),config('access.two_factor_auth')], 'prefix' => 'user', 'as' => 'user.', 'namespace' => 'Auth'], function () {

    Route::get('user/payment/withdraw', 'PaymentManagementController@withdraw')->name('payment.withdraw');
    Route::get('user/payment/deposit', 'PaymentManagementController@deposit')->name('payment.deposit');

    Route::post('user/payment/withdraw/amount', 'PaymentManagementController@withDrawAmount')->name('payment.withdraw.save');
    Route::post('user/payment/deposit/amount', 'PaymentManagementController@depositAmount')->name('payment.deposit.save');
});

// Routes for both admin and customer

Route::group(['middleware' => 'auth', 'prefix' => 'user', 'as' => 'user.', 'namespace' => 'Auth'], function () {

    Route::get('payment/deposit/history', 'PaymentManagementController@depositHistory')->name('payment.deposit.history');
    Route::get('payment/withdraw/history', 'PaymentManagementController@withdrawHistory')->name('payment.withdraw.history');
});
