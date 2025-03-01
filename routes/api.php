<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use VS\Admin\Http\Controllers\AdminAuthController;
use VS\Admin\Http\Controllers\AdminPasswordController;
use VS\Admin\Http\Controllers\AdminController;
use VS\Admin\Http\Controllers\AdminEmailVerificationController;
use VS\Auth\Classes\EmailVerificationRoutes;
use VS\Auth\Classes\AuthRoutes;

// Auth Routes
// Guest Routes
Route::get('test', function () {
    return 'test';
});

EmailVerificationRoutes::make(AdminEmailVerificationController::class, 'admin');

AuthRoutes::make(AdminAuthController::class, 'admin');


// Authenticated Routes
Route::group(['middleware' => ['api', 'auth:admin', 'vs-auth.verified:admin']], function () {

    // Self Admin Routes
    Route::put('password/update', [AdminPasswordController::class, 'update'])->name('password.update');

    Route::get('/', [AdminController::class, 'index'])->name('index');

});

