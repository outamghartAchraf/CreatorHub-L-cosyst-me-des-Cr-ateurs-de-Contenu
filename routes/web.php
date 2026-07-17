<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;

Route::get('/feed', [PortfolioController::class, 'feed'])->name('feed');
