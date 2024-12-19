<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GameController;
use App\Http\Controllers\API\GameStatisticsController;
use App\Http\Controllers\API\LeaderboardController;
use App\Http\Controllers\API\PlayerResultsController;
use App\Http\Controllers\API\PlayerResultStatsController;
use App\Http\Controllers\API\QuizController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Auth routes
Route::post('/login', [AuthController::class, 'login']);        //ok
Route::post('/register', [AuthController::class, 'register']);      //ok

Route::middleware(['auth:sanctum'])->group(function () {
    // auth
    Route::post('/logout', [AuthController::class, 'logout']);                  //ok

    //quiz
    Route::post('/quizzes', [QuizController::class, 'createQuiz']);         //ok
    Route::get('/quizzes', [QuizController::class, 'getQuizzes']);
    Route::get('/quizzes/{id}', [QuizController::class, 'getQuiz']);
    Route::delete('/quizzes/{id}', [QuizController::class, 'deleteQuiz']);   //ok
    Route::put('/quizzes/{id}', [QuizController::class, 'updateQuiz']);         //ok
    Route::post('/quizzes/{quizId}/questions', [QuizController::class, 'addQuestion']); //ok
    Route::get('/quizzes/{quizId}/questions', [QuizController::class, 'getQuestions']); //pk

    //game
    Route::post('game', [GameController::class, 'createGame']);  // Tạo game mới
    Route::get('games', [GameController::class, 'getGames']);  // Lấy tất cả các game
    Route::get('game/{id}', [GameController::class, 'getGame']);  // Lấy game theo ID
    Route::delete('game/{id}', [GameController::class, 'deleteGame']);  // Xóa game theo ID
    Route::put('game/{id}', [GameController::class, 'updateGame']);  // Cập nhật game theo ID
    Route::post('game/{gameId}/add-player', [GameController::class, 'addPlayer']);  // Thêm player vào game

    //leaderboard
    Route::post('leaderboard', [LeaderboardController::class, 'createLeaderboard']);
    Route::get('leaderboard/{id}', [LeaderboardController::class, 'getLeaderboard']);
    Route::post('leaderboard/{leaderboardId}/add-player-result', [LeaderboardController::class, 'addPlayerResult']);
    Route::put('leaderboard/{leaderboardId}/update-question-leaderboard', [LeaderboardController::class, 'updateQuestionLeaderboard']);
    Route::put('leaderboard/{leaderboardId}/update-current-leaderboard', [LeaderboardController::class, 'updateCurrentLeaderboard']);

    //Player




});
