<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->prefix('permissions')->group(function () {
    Route::get('/', function() {
        return view('permissions::web.index');
    });
});


