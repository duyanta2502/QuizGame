<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function show($id)
    {
        $question = Question::find($id);

        if (!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }

        return response()->json($question);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'question_txt' => 'required|string',
            'time_limit' => 'required|integer',
            'answer_1' => 'required|string',
            'answer_2' => 'required|string',
            'answer_3' => 'required|string',
            'answer_4' => 'required|string',
            'correct_answer' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $question = Question::create($validated);

        return response()->json($question, 201);
    }

    public function update(Request $request, $id)
    {
        $question = Question::find($id);

        if (!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }

        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'question_txt' => 'required|string',
            'time_limit' => 'required|integer',
            'answer_1' => 'required|string',
            'answer_2' => 'required|string',
            'answer_3' => 'required|string',
            'answer_4' => 'required|string',
            'correct_answer' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $question->update($validated);

        return response()->json($question);
    }

    public function destroy($id)
    {
        $question = Question::find($id);

        if (!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }

        $question->delete();

        return response()->json(['message' => 'Question deleted successfully']);
    }
}
