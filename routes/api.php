<?php

use VS\Admin\Http\Controllers\AdminEmailVerificationController;
use VS\Admin\Http\Controllers\AdminPasswordController;
use VS\Admin\Http\Controllers\AdminAuthController;
use VS\Admin\Http\Controllers\AdminController;
use VS\Auth\Classes\EmailVerificationRoutes;
use Illuminate\Support\Facades\Route;
use VS\Auth\Classes\PasswordRoutes;
use VS\Auth\Classes\AuthRoutes;
use VS\Auth\Classes\OTPRoutes;

// Auth Routes
// Guest Routes
Route::get('test', function () {
    return 'test';
});

EmailVerificationRoutes::make(AdminEmailVerificationController::class, 'admin');

PasswordRoutes::make(AdminPasswordController::class, 'admin');

AuthRoutes::make(AdminAuthController::class, 'admin');

OTPRoutes::make('admin');


// Authenticated Routes
Route::group(['middleware' => ['api', 'auth:admin', 'vs-auth.verified:admin']], function () {

    // Self Admin Routes
    Route::put('password/update', [AdminPasswordController::class, 'update'])->name('password.update');

    Route::get('/', [AdminController::class, 'index'])->name('index');

});
