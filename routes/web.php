<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/feed', [PorfolioController::class, 'feed'])->name('feed');

Route::middleware(['auth'])->group(function ()
{  Route::get('/portfolios/create', [PortfolioController::class, 'create'])->name('portfolios.create');
    Route::post('/portfolios', [PortfolioController::class, 'store'])->name('portfolios.store');
});
