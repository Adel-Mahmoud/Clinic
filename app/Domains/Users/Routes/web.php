<?php

use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::get('/', [App\Domains\Users\Controllers\Web\UserEntityController::class, 'index']);
});