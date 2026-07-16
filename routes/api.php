<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\ApplicationController;



Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

});
Route::apiResource('jobs', JobController::class);

Route::post('/jobs/{job}/apply', [ApplicationController::class, 'apply']);

Route::get('/jobs/{job}/applications', [ApplicationController::class, 'index']);

Route::put('/applications/{application}', [ApplicationController::class, 'update']);
