<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PlayerResultStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PlayerResultStatsController extends Controller
{
    public function index()
    {
        return response()->json(PlayerResultStat::all(), 200);
    }

    public function show($id)
    {
        $stat = PlayerResultStat::find($id);
        if (!$stat) {
            return response()->json(['message' => 'Player result stat not found'], 404);
        }
        return response()->json($stat, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'game_id' => 'required|integer|exists:games,id',
            'player_result_id' => 'required|integer|exists:player_results,id',
            'player_id' => 'required|integer|exists:users,id',
            'average_time_per_question' => 'numeric',
        ]);

        $stat = PlayerResultStat::create($validatedData);
        return response()->json($stat, 201);
    }

    public function update(Request $request, $id)
    {
        $stat = PlayerResultStat::find($id);
        if (!$stat) {
            return response()->json(['message' => 'Player result stat not found'], 404);
        }

        $validatedData = $request->validate([
            'average_time_per_question' => 'numeric',
        ]);

        $stat->update($validatedData);
        return response()->json($stat, 200);
    }

    public function destroy($id)
    {
        $stat = PlayerResultStat::find($id);
        if (!$stat) {
            return response()->json(['message' => 'Player result stat not found'], 404);
        }

        $stat->delete();
        return response()->json(['message' => 'Player result stat deleted successfully'], 200);
    }
}
