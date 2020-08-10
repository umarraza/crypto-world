<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\MessageController;
use App\Http\Controllers\Auth\Admin\UserController;

/*
 * Global Routes
 * Routes that are used between both frontend users and admin.
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect('/login');
});

Auth::routes();

Route::get('percentage', [CronController::class, 'getPercentage'])->name('percentage');

Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('profile/{user}/edit', [ProfileController::class, 'profile'])->name('profile');
Route::patch('profile/{user}', [ProfileController::class, 'update'])->name('profile.update');

// Two factor auth rputes

// apply middleware to disable access to these routes if user is verified 
Route::get('verify', 'Auth\TwoFactorController@index')->name('verify.index’');
Route::get('verify/resend', 'Auth\TwoFactorController@resend')->name('verify.resend');
Route::resource('verify', 'Auth\TwoFactorController')->only(['index', 'store']);


// Admin Routes
Route::group(['middleware' => [config('access.users.super_admin'),config('access.two_factor_auth')],'prefix' => 'admin', 'as' => 'admin.','namespace' => 'Auth\Admin'], function () {
    
    Route::get('home', [HomeController::class, 'index'])->name('home');
    
    Route::get('inbox', [MessageController::class, 'adminInbox'])->name('inbox');
    Route::post('message/store', [MessageController::class, 'storeAdminMessage'])->name('messages.store');
    
    Route::post('user/messages', [MessageController::class, 'getUserMessages'])->name('getMessages');
    Route::get('conversations', [MessageController::class, 'getConversations']);

    Route::resource('user', 'UserController');
    Route::resource('notification', 'NotificationController');

    Route::get('notification/{notification}/delete', 'NotificationController@destroy')->name('notification.delete');

    Route::get('user/{user}/delete', 'UserController@destroy')->name('user.delete');
    Route::get('user/payment/deposit', 'UserController@deposit')->name('payment.deposit');
    Route::post('user/payment/deposit', 'UserController@depositAmount')->name('payment.deposit.store');

    Route::get('users/unpaid', 'UserController@unpaid')->name('unpaid.users');
    
    Route::get('active/{user}', 'UserActivationController@activate')->name('user.active');
    Route::get('unactive/{user}', 'UserActivationController@unactivate')->name('user.unactive');

    Route::get('confirm/{user}', 'UserConfirmationController@confirm')->name('user.confirm');
    Route::get('unconfirm/{user}', 'UserConfirmationController@unconfirm')->name('user.unconfirm');

    Route::get('payment/withdraw/requests', 'PaymentRequestController@withdrawRequests')->name('payment.withdraw.requests');
    Route::get('payment/withdraw/request/accept', 'PaymentRequestController@withdrawRequestAction')->name('payment.withdraw.request.action');
});

// Customer Routes
Route::group(['middleware' => [config('access.users.customer_role'),config('access.two_factor_auth')],'prefix' => 'user', 'as' => 'user.','namespace' => 'Auth'], function () {

    Route::get('messages', 'MessageController@userInbox')->name('messages');
    Route::get('messages/all', 'MessageController@getMessages');
    Route::post('messages/store', 'MessageController@store')->name('messages.store');

    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('users/level/{id}', [UserController::class, 'usersByLevel'])->name('user-by-levels');

    Route::get('payment/withdraw', 'PaymentManagementController@withdraw')->name('payment.withdraw');
    Route::get('payment/deposit', 'PaymentManagementController@deposit')->name('payment.deposit');

    Route::get('payment/roi/transfer', 'PaymentManagementController@transferRoiPayment')->name('payment.roi.transfer');

    Route::get('payment/team/bonus/transfer', 'PaymentManagementController@transferTeamBonusPayment')->name('payment.team.bonus.transfer');

    Route::get('payment/deposit/history', 'PaymentManagementController@depositHistory')->name('payment.deposit.history');
    Route::get('payment/withdraw/history', 'PaymentManagementController@withdrawHistory')->name('payment.withdraw.history');


    Route::get('payment/roi/history', 'PaymentManagementController@roiHistory')->name('payment.roi.history');
    Route::get('payment/team/bonus/history', 'PaymentManagementController@teamBonusHistory')->name('payment.team.bonus.history');

    Route::post('payment/withdraw/amount', 'PaymentManagementController@withDrawAmount')->name('payment.withdraw.save');
    Route::post('payment/deposit/amount', 'PaymentManagementController@depositAmount')->name('payment.deposit.save');

    Route::get('ipnbtc', 'PaymentManagementController@ipnbtc');

    Route::get('invite/refferal/index', [UserController::class, 'inviteRefferalUser'])->name('invite.refferal.index');
    Route::post('invite/refferal', [UserController::class, 'invite'])->name('invite.refferal');

    Route::get('verify/payment/withdraw', 'PaymentManagementController@withDrawAmountIndex')->name('verify.payment.index');
    Route::post('verify/withdraw', 'PaymentManagementController@verifyWithdraw')->name('verify.payment.withdraw');
});
