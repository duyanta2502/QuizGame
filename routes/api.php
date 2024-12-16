<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GamesController;
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
    Route::post('/logout', [AuthController::class, 'logout']);                  //ok
    // Quiz routes
    Route::get('/quizzes/public', [QuizController::class, 'getPublicQuizzes']);
    Route::get('/quizzes/search', [QuizController::class, 'search']);
    Route::get('/quizzes/teacher/{teacherId}', [QuizController::class, 'getTeacherQuizzes']);
    Route::patch('/quizzes/{id}/likeQuiz', [QuizController::class, 'like']);
    Route::post('/quizzes/{id}/commentQuiz', [QuizController::class, 'comment']);
    Route::post('/quizzes/{quizId}/questions', [QuizController::class, 'addQuestion']);
    Route::get('/quizzes/{quizId}/questions', [QuizController::class, 'getQuestions']);
    Route::get('/quizzes/{quizId}/questions/{questionId}', [QuizController::class, 'getQuestion']);
    Route::patch('/quizzes/{quizId}/questions/{questionId}', [QuizController::class, 'updateQuestion']);
    Route::delete('/quizzes/{quizId}/questions/{questionId}', [QuizController::class, 'destroyQuestion']);
    Route::apiResource('/quizzes', QuizController::class);

    // Game routes
    Route::patch('/games/{gameId}/players', [GamesController::class, 'addPlayer']);
    Route::apiResource('/games', GamesController::class);

    // Player Result routes
    Route::patch('/player-results/{playerResultId}/answers', [PlayerResultsController::class, 'addAnswer']);
    Route::get('/player-results/{playerResultId}/answers', [PlayerResultsController::class, 'getAnswers']);
    Route::get('/player-results/{playerResultId}/answers/{answerId}', [PlayerResultsController::class, 'getAnswer']);
    Route::patch('/player-results/{playerResultId}/answers/{answerId}', [PlayerResultsController::class, 'updateAnswer']);
    Route::delete('/player-results/{playerResultId}/answers/{answerId}', [PlayerResultsController::class, 'destroyAnswer']);
    Route::apiResource('/player-results', PlayerResultsController::class);

    // Leaderboard routes
    Route::patch('/leaderboards/{leaderboardId}/playerresult', [LeaderboardController::class, 'addPlayerResult']);
    Route::patch('/leaderboards/{leaderboardId}/questionleaderboard', [LeaderboardController::class, 'updateQuestionLeaderboard']);
    Route::patch('/leaderboards/{leaderboardId}/currentleaderboard', [LeaderboardController::class, 'updateCurrentLeaderboard']);
    Route::apiResource('/leaderboards', LeaderboardController::class);
});
