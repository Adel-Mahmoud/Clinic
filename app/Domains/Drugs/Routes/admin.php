<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Drugs\Controllers\Admin\DrugEntityController;

Route::middleware(['web','auth.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('drugs', DrugEntityController::class);
    Route::post('drugs/import', [DrugEntityController::class, 'import'])->name('drugs.import');
});
