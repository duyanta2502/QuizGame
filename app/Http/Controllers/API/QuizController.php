<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class QuizController extends Controller
{
    public function index()
    {
        return response()->json(Quiz::all(), 200);
    }

    public function show($id)
    {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }
        return response()->json($quiz, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:quizzes,name|max:150',
            'description' => 'string',
            'background_image' => 'string|max:255',
            'creator_id' => 'required|integer|exists:users,id',
            'points_per_question' => 'integer',
            'number_of_questions' => 'integer',
            'is_public' => 'boolean',
            'tags' => 'array',
            'likes_count' => 'integer',
            'comments_count' => 'integer',
        ]);

        $quiz = Quiz::create($validatedData);
        return response()->json($quiz, 201);
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'string|unique:quizzes,name,' . $id . '|max:150',
            'description' => 'string',
            'background_image' => 'string|max:255',
            'points_per_question' => 'integer',
            'number_of_questions' => 'integer',
            'is_public' => 'boolean',
            'tags' => 'array',
            'likes_count' => 'integer',
            'comments_count' => 'integer',
        ]);

        $quiz->update($validatedData);
        return response()->json($quiz, 200);
    }

    public function destroy($id)
    {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        $quiz->delete();
        return response()->json(['message' => 'Quiz deleted successfully'], 200);
    }
}
