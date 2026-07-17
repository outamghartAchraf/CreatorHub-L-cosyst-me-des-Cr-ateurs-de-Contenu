<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PortfolioController; 

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/feed', [PortfolioController::class, 'feed']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/portfolios', [PortfolioController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
