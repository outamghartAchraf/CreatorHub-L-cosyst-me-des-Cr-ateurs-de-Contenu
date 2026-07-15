<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;


Route::get('/', function () {
    return view('welcome');
});
