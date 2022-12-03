<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::name('admin.')->group(function() {
    // login
    Route::middleware('guest:admin', 'PreventBackHistory')->group(function() {
        Route::view('/login', 'admin.auth.login')->name('login');
        Route::post('/check', [AuthController::class, 'check'])->name('check');
    });

    // profile
    Route::middleware('auth:admin', 'PreventBackHistory')->group(function() {
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // users
        Route::prefix('users')->name('users.')->group(function() {
            Route::get('/', [UserController::class, 'index'])->name('list.all');
        });

        // order
        Route::prefix('order')->name('order.')->group(function() {
            Route::get('/', [OrderController::class, 'index'])->name('list.all');
            Route::get('/detail/{id}', [OrderController::class, 'detail'])->name('detail');
        });
    });
});