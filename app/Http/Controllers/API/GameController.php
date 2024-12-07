<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $game = Game::with('questions')->find($id);
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

    public function checkCodeQuizz(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|max:10',
        ]);

        $code = $validatedData['code'];

        $game = Game::where('code', $code)->first();

        if (!$game) {
            return response()->json([
                'result' => false,
                'message' => 'Game not found'
            ], 404);
        }

        $now = Carbon::now();
        if ($now < $game->start_time) {
            return response()->json([
                'result' => false,
                'message' => 'The game has not started yet'
            ], 400);
        }

        return response()->json([
            'result' => true,
            'message' => 'Code is valid and the game is ready',
            'game' => $game
        ], 200);
    }

    public function getQrQuizz($id)
    {
        $quizUrl = 'https://localhost:3000/play/quizz/' . $id;

        $qrCode = QrCode::format('png')->size(300)->generate($quizUrl);

        return response($qrCode, 200)
                ->header('Content-Type', 'image/png');
    }
}
