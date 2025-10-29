<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Examinations\Controllers\Admin\ExaminationEntityController;

Route::middleware(['web', 'auth.admin'])->prefix('admin')->group(function () {
    Route::prefix('examinations')->group(function () {
        Route::get('/', [ExaminationEntityController::class, 'index']);
        Route::post('/store', [ExaminationEntityController::class, 'store'])
            ->name('admin.examinations.store');
    });
});
