<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PortfolioController; 
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\Api\TaskController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/feed', [PortfolioController::class, 'feed']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/portfolios', [PortfolioController::class, 'store']);

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

 Route::post(
        '/workspaces/{workspace}/members',
        [WorkspaceController::class, 'addMember']
    );

    Route::delete(
        '/workspaces/{workspace}/members/{user}',
        [WorkspaceController::class, 'removeMember']
    );

    Route::get(
        '/workspaces/{workspace}/members',
        [WorkspaceController::class, 'members']
    );

    Route::patch(
    '/tasks/{task}/validate',
    [TaskController::class, 'validateTask']
);


    Route::post('/logout', [AuthController::class, 'logout']);
});


