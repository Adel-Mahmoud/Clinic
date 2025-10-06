<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->prefix('doctors')->group(function () {
    Route::get('/', [App\Domains\Doctors\Controllers\Web\DoctorEntityController::class, 'index']);
});