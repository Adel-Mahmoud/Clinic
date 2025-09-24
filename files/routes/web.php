<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/get',[AuthController::class, 'user']);

Route::get('/{page}', [AdminController::class, 'index']);
