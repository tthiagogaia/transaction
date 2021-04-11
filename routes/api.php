<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterUserController::class, 'store'])->middleware('guest');

Route::post('/login', [LoginController::class, 'store'])->middleware('guest');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LogoutController::class, 'destroy']);

    Route::post('/company', [CompanyController::class, 'store']);
});
