    <?php

    use App\Http\Controllers\API\AuthController;
    use App\Http\Controllers\API\GameController;
    use App\Http\Controllers\API\QuestionController;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Http\Request;
        
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/quizz/{id}', [GameController::class, 'show']);
        Route::post('/quizz/store', [GameController::class, 'store']);
        Route::post('/quizz/{id}/update', [GameController::class, 'update']);
        Route::delete('/quizz/{id}', [GameController::class, 'destroy']);
        Route::post('/quizz/checkCodeQuizz', [GameController::class, 'checkCodeQuizz']);
        Route::get('/quizz/{id}/qrQuizz', [GameController::class, 'getQrQuizz']);

        Route::get('/question/{id}', [QuestionController::class, 'show']);
        Route::post('/question/store', [QuestionController::class, 'store']);
        Route::post('/question/{id}/update', [QuestionController::class, 'update']);
        Route::delete('/question/{id}', [QuestionController::class, 'destroy']);
    });
