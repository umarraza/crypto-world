<?php

use Illuminate\Support\Facades\Route;

/*
 * Global Routes
 * Routes that are used between both frontend sssusers and admin.
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

/*
 * Admin Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => [config('access.users.super_admin')]], function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     * These routes can not be hit if the password is expired
     */
    include_route_files(__DIR__.'/backend/');
});


/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    include_route_files(__DIR__.'/frontend/');
});