<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->prefix('patients')->group(function () {
    Route::get('/', [App\Domains\Patients\Controllers\Web\PatientEntityController::class, 'index']);
});