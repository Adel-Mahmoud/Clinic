<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Reports\Controllers\ReportEntityController;

Route::middleware(['web','auth.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/reports', [ReportEntityController::class , 'index'])->name('reports');
});


