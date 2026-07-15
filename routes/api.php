<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\Api\TaskController;



Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource(
        'workspaces',
        WorkspaceController::class
    );

        Route::apiResource('tasks', TaskController::class);

        Route::patch(
    '/tasks/{task}/status',
    [TaskController::class, 'updateStatus']
);

Route::post(
    '/tasks/{task}/submit',
    [TaskController::class, 'submitDeliverable']
);

    Route::post('/logout', [AuthController::class, 'logout']);

});


