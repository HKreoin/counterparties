<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CounterpartyController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::get('/', function () {
    return Inertia\Inertia::render('Welcome', []);
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::resource('counterparties', CounterpartyController::class)
        ->only(['index', 'create', 'store'])->names('counterparties');
    Route::post('logout', [AuthController::class, 'logout'])
        ->name('logout');
});
