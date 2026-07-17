<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;

Route::get('/feed', [PortfolioController::class, 'feed'])->name('feed');

Route::get('/portfolios/create', [PortfolioController::class, 'create'])->name('portfolios.create');

Route::post('/portfolios', [PortfolioController::class, 'store'])->name('portfolios.store');
