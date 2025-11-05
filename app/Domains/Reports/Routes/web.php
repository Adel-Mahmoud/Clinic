<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->prefix('reports')->group(function () {
    Route::get('/', function() {
        return view('reports::web.index');
    });
});


