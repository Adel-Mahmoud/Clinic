<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Auth\Controllers\Admin\LoginController;

Route::prefix('admin')->middleware('web')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login.submit');
    Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('register', [LoginController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('register', [LoginController::class, 'register'])->name('admin.register.submit');

    Route::middleware('auth.admin')->group(function () {
        Route::get('dashboard', function () {
            return 'Admin Dashboard';
        })->name('admin.dashboard');
    });
});
