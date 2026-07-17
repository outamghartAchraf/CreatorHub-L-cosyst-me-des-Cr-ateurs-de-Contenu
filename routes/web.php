<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;

Route::get('/feed', [PortfolioController::class, 'feed']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/portfolios', [PortfolioController::class, 'store']);
});
