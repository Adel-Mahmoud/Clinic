<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->prefix('examinations')->group(function () {
    Route::get('/', [App\Domains\Examinations\Controllers\Web\ExaminationEntityController::class, 'index']);
});