<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use VS\Admin\Http\Controllers\AdminAuthController;
use VS\Admin\Http\Controllers\AdminPasswordController;
use VS\Admin\Http\Controllers\AdminController;
use VS\Admin\Http\Controllers\AdminEmailVerificationController;

// Auth Routes
// Guest Routes
//Route::get('test', function () {
//    return 'test';
//})->name('verification.verify');

Route::get('/email/verify/{id}/{hash}', [AdminEmailVerificationController::class, 'verify'])->name('api.admin.verification.verify');

Route::middleware(['auth:admin'])->group(function () {
    Route::post('/email/verify/resend', [AdminEmailVerificationController::class, 'resend'])->name('api.admin.verification.resend');
});


Route::group(['middleware' => ['vs-auth.client.auth', 'api', ], 'as' => 'vs.admin.'], function () {
    Route::post('register', [AdminAuthController::class, 'register'])->name('register');
    Route::post('login', [AdminAuthController::class, 'login'])->middleware('verified')->name('login');
});


// Authenticated Routes
Route::group(['middleware' => ['api', 'force.json', 'auth:admin', 'verified'], 'as' => 'vs.admin.'], function () {

    // Auth Routes
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Self Admin Routes
    Route::put('password/update', [AdminPasswordController::class, 'update'])->name('password.update');

    Route::get('/', [AdminController::class, 'index'])->name('index');

});

