<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/quizz/{id}', [GameController::class, 'show']);
    Route::post('/quizz/store', [GameController::class, 'store']);
    Route::post('/quizz/{id}/update', [GameController::class, 'update']);
    Route::delete('/quizz/{id}', [GameController::class, 'destroy']);
});