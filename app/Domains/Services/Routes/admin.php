<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Services\Controllers\Admin\ServiceEntityController;

Route::middleware(['web','auth.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('services', ServiceEntityController::class);
});
