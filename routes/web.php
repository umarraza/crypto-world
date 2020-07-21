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

Route::group(['namespace' => 'Auth\Admin'], function () {
    Route::post('save/save', [UserController::class, 'save'])->name('user.save');
});

Route::group(['middleware' => config('access.users.super_admin'), 'prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Auth\Admin'], function () {
    Route::resource('user', 'UserController');

    Route::get('confirm/{user}', ['uses' => 'UserConfirmationController@confirm', 'as' => 'user.confirm']);
    Route::get('unconfirm/{user}', ['uses' => 'UserConfirmationController@unconfirm', 'as' => 'user.unconfirm']);

    // Route::get('active/{user}', ['uses' => 'UserActivationController@confirm', 'as' => 'user.active']);
    // Route::get('unactive/{user}', ['uses' => 'UserActivationController@unconfirm', 'as' => 'user.unactive']);
});