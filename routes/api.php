<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\CounterpartyController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/v1/register', [AuthController::class, 'register']);
Route::post('/v1/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::apiResource('counterparties', CounterpartyController::class)
        ->only(['index', 'store']);
    Route::post('logout', [AuthController::class, 'logout']);
});
