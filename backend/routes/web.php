<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudgetsController;
use App\Http\Controllers\GoalsController;
use Illuminate\Support\Facades\Route;



Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::prefix('goals')->group(function() {
    Route::post('/create', [GoalsController::class, 'create']);
    Route::post('/edit', [GoalsController::class, 'edit']);
    Route::post('/get', [GoalsController::class, 'getGoals']);
    Route::post('/delete', [GoalsController::class, 'delete']);
});


Route::prefix('budgets')->group(function() {
    Route::post('/create', [BudgetsController::class, 'create']);
    Route::post('/edit', [BudgetsController::class, 'edit']);
    Route::post('/get', [BudgetsController::class, 'getBudgets']);
    Route::post('/delete', [BudgetsController::class, 'delete']);
});