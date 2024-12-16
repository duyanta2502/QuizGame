<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Leaderboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LeaderboardController extends Controller
{
    public function index()
    {
        return response()->json(Leaderboard::all(), 200);
    }

    public function show($id)
    {
        $leaderboard = Leaderboard::find($id);
        if (!$leaderboard) {
            return response()->json(['message' => 'Leaderboard not found'], 404);
        }
        return response()->json($leaderboard, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'game_id' => 'required|integer|exists:games,id',
            'player_result_list' => 'array',
            'question_leaderboard' => 'array',
        ]);

        $leaderboard = Leaderboard::create($validatedData);
        return response()->json($leaderboard, 201);
    }

    public function update(Request $request, $id)
    {
        $leaderboard = Leaderboard::find($id);
        if (!$leaderboard) {
            return response()->json(['message' => 'Leaderboard not found'], 404);
        }

        $validatedData = $request->validate([
            'player_result_list' => 'array',
            'question_leaderboard' => 'array',
        ]);

        $leaderboard->update($validatedData);
        return response()->json($leaderboard, 200);
    }

    public function destroy($id)
    {
        $leaderboard = Leaderboard::find($id);
        if (!$leaderboard) {
            return response()->json(['message' => 'Leaderboard not found'], 404);
        }

        $leaderboard->delete();
        return response()->json(['message' => 'Leaderboard deleted successfully'], 200);
    }
}
