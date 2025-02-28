<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use VS\Admin\Http\Controllers\AdminAuthController;
use VS\Admin\Http\Controllers\AdminPasswordController;
use VS\Admin\Http\Controllers\AdminController;

// Auth Routes
// Guest Routes
Route::get('test', function () {
    return 'test';
});

Route::group(['middleware' => ['vs-auth.client.auth', 'api'], 'as' => 'vs.admin.'], function () {
    Route::post('login', [AdminAuthController::class, 'login'])->name('login');
});

// Authenticated Routes
Route::group(['middleware' => ['api', 'force.json', 'auth:admin'], 'as' => 'vs.admin.'], function () {
    // Auth Routes
    Route::post('register', [AdminAuthController::class, 'register'])->name('register');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Self Admin Routes
    Route::put('password/update', [AdminPasswordController::class, 'update'])->name('password.update');

    Route::get('/', [AdminController::class, 'index'])->name('index');

});

