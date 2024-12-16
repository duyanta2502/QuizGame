<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\GameStatistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class GameStatisticsController extends Controller
{
    public function index()
    {
        return response()->json(GameStatistic::all(), 200);
    }

    public function show($id)
    {
        $statistic = GameStatistic::find($id);
        if (!$statistic) {
            return response()->json(['message' => 'Game statistic not found'], 404);
        }
        return response()->json($statistic, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'game_id' => 'required|integer|exists:games,id',
            'player_result_list' => 'array',
            'average_time_per_question' => 'numeric',
            'average_points_per_question' => 'numeric',
        ]);

        $statistic = GameStatistic::create($validatedData);
        return response()->json($statistic, 201);
    }

    public function update(Request $request, $id)
    {
        $statistic = GameStatistic::find($id);
        if (!$statistic) {
            return response()->json(['message' => 'Game statistic not found'], 404);
        }

        $validatedData = $request->validate([
            'player_result_list' => 'array',
            'average_time_per_question' => 'numeric',
            'average_points_per_question' => 'numeric',
        ]);

        $statistic->update($validatedData);
        return response()->json($statistic, 200);
    }

    public function destroy($id)
    {
        $statistic = GameStatistic::find($id);
        if (!$statistic) {
            return response()->json(['message' => 'Game statistic not found'], 404);
        }

        $statistic->delete();
        return response()->json(['message' => 'Game statistic deleted successfully'], 200);
    }
}
