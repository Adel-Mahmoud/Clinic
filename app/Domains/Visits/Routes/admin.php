<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Visits\Controllers\Admin\VisitEntityController;

Route::middleware(['web','auth.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('visits', VisitEntityController::class);
});
