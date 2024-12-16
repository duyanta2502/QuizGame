<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class GamesController extends Controller
{
    public function index()
    {
        return response()->json(Game::all(), 200);
    }

    public function show($id)
    {
        $game = Game::find($id);
        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }
        return response()->json($game, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'host_id' => 'required|integer|exists:users,id',
            'quiz_id' => 'required|integer|exists:quizzes,id',
            'pin' => 'required|string|unique:games,pin|max:10',
            'is_live' => 'boolean',
            'player_list' => 'array',
        ]);

        $game = Game::create($validatedData);
        return response()->json($game, 201);
    }

    public function update(Request $request, $id)
    {
        $game = Game::find($id);
        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        $validatedData = $request->validate([
            'pin' => 'string|unique:games,pin,' . $id . '|max:10',
            'is_live' => 'boolean',
            'player_list' => 'array',
        ]);

        $game->update($validatedData);
        return response()->json($game, 200);
    }

    public function destroy($id)
    {
        $game = Game::find($id);
        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        $game->delete();
        return response()->json(['message' => 'Game deleted successfully'], 200);
    }
}
