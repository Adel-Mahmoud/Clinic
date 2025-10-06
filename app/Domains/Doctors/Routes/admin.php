<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web','auth.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('doctors', App\Domains\Doctors\Controllers\Admin\DoctorEntityController::class);
});