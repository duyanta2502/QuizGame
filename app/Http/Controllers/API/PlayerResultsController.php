<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PlayerResult;    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PlayerResultsController extends Controller
{
    public function index()
    {
        return response()->json(PlayerResult::all(), 200);
    }

    public function show($id)
    {
        $playerResult = PlayerResult::find($id);
        if (!$playerResult) {
            return response()->json(['message' => 'Player result not found'], 404);
        }
        return response()->json($playerResult, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'player_id' => 'required|integer|exists:users,id',
            'game_id' => 'required|integer|exists:games,id',
            'score' => 'required|integer',
            'answers' => 'array',
        ]);

        $playerResult = PlayerResult::create($validatedData);
        return response()->json($playerResult, 201);
    }

    public function update(Request $request, $id)
    {
        $playerResult = PlayerResult::find($id);
        if (!$playerResult) {
            return response()->json(['message' => 'Player result not found'], 404);
        }

        $validatedData = $request->validate([
            'score' => 'integer',
            'answers' => 'array',
        ]);

        $playerResult->update($validatedData);
        return response()->json($playerResult, 200);
    }

    public function destroy($id)
    {
        $playerResult = PlayerResult::find($id);
        if (!$playerResult) {
            return response()->json(['message' => 'Player result not found'], 404);
        }

        $playerResult->delete();
        return response()->json(['message' => 'Player result deleted successfully'], 200);
    }
}
