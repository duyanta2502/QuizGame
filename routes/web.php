<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route đăng nhập
Route::get('/login', function () {
    return view('auth.login'); // Trả về giao diện login
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

// Route đăng ký
Route::get('/register', function () {
    return view('auth.register'); // Trả về giao diện đăng ký
})->name('register');

Route::post('/register', [AuthController::class, 'register']);

// Middleware bảo vệ các route cần đăng nhập
Route::middleware(['auth'])->group(function () {
    // Route đăng xuất
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Quản lý Quiz
    Route::get('/quizz/{id}', [GameController::class, 'showView'])->name('quizz.show');
    Route::post('/quizz/store', [GameController::class, 'store'])->name('quizz.store');
    Route::post('/quizz/{id}/update', [GameController::class, 'update'])->name('quizz.update');
    Route::delete('/quizz/{id}', [GameController::class, 'destroy'])->name('quizz.destroy');
    Route::post('/quizz/checkCodeQuizz', [GameController::class, 'checkCodeQuizz'])->name('quizz.checkCode');
    Route::get('/quizz/{id}/qrQuizz', [GameController::class, 'getQrQuizz'])->name('quizz.qr');

    // Quản lý câu hỏi
    Route::get('/question/{id}', [QuestionController::class, 'showView'])->name('question.show');
    Route::post('/question/store', [QuestionController::class, 'store'])->name('question.store');
    Route::post('/question/{id}/update', [QuestionController::class, 'update'])->name('question.update');
    Route::delete('/question/{id}', [QuestionController::class, 'destroy'])->name('question.destroy');
});
