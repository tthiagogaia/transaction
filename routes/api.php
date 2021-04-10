<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterUserController::class, 'store'])->middleware('guest');

Route::post('/login', [LoginController::class, 'store'])->middleware('guest');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/logout', [LogoutController::class, 'destroy'])->middleware('auth:sanctum');
