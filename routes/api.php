<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [LoginController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');

    Route::post('/company', [CompanyController::class, 'store'])->name('company.store');

    Route::post('/transaction/credit', [TransactionController::class, 'credit'])->name('transaction.credit');
});
