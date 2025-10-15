<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web','auth.admin'])->prefix('admin')->group(function () {
    Route::prefix('examinations')->group(function () {
        Route::get('/', [App\Domains\Examinations\Controllers\Admin\ExaminationEntityController::class, 'index']);
    });
});