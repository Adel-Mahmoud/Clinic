<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web','auth.admin'])->prefix('admin')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [App\Domains\Users\Controllers\Admin\UserEntityController::class, 'index']);
    });
});