<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        return response()->json(Game::all());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'game_title' => 'required|string|max:255',
            'start_time' => 'nullable|date',
        ]);

        $validatedData['creator_id'] = $request->user()->id;
        $game = Game::create($validatedData);

        return response()->json($game, 201);
    }

    public function show(string $id)
    {
        $game = Game::find($id);
        if (!$game) {
            return response()->json(['error' => 'Game not found'], 404);
        }
        return response()->json($game);
    }

    public function update(Request $request, string $id)
    {
        $game = Game::find($id);
        if (!$game) {
            return response()->json(['error' => 'Game not found'], 404);
        }

        $validatedData = $request->validate([
            'creator_id' => 'exists:users,id',
            'game_title' => 'string|max:255',
        ]);

        $game->update($validatedData);
        return response()->json($game);
    }

    public function destroy(string $id)
    {
        $game = Game::find($id);
        if (!$game) {
            return response()->json(['error' => 'Game not found'], 404);
        }

        $game->delete();
        return response()->json(['message' => 'Game deleted successfully']);
    }
}
