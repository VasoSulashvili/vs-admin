<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use VS\Admin\Http\Controllers\RegisterController;
use VS\Admin\Http\Controllers\LoginController;
use VS\Admin\Http\Controllers\LogoutController;
use VS\Admin\Http\Controllers\AdminController;

// Auth Routes
// Guest Routes
Route::get('test', function () {
    return 'test';
});

Route::group(['middleware' => 'vs-auth.client.auth', 'as' => 'vs.admin.'], function () {
    Route::post('register', RegisterController::class)->name('register');
    Route::post('login', LoginController::class)->name('login');
});
// Authenticated Routes
Route::group(['middleware' => 'auth:admin', 'as' => 'vs.admin.'], function () {
    Route::post('logout', LogoutController::class)->name('logout');

    Route::get('/', [AdminController::class, 'index'])->name('me');


});

