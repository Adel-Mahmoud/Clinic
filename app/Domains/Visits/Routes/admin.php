<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Visits\Controllers\Admin\VisitEntityController;

Route::middleware(['web', 'auth.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('visits/create/{id}', [VisitEntityController::class, 'create'])
        ->name('visits.create.with.patient');
    Route::resource('visits', VisitEntityController::class);
});
