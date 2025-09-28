<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Users\Controllers\Web\UserController;

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/{id}', [UserController::class, 'show'])->name('show');
});
