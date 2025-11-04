<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Patients\Controllers\Admin\PatientEntityController;

Route::middleware(['web','auth.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('patients', PatientEntityController::class);
    Route::get('/history/{id}', [PatientEntityController::class, 'history'])
            ->name('patient.history');
});