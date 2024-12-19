<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\PlayerResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    // Tạo game mới
    public function createGame(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'host_id' => 'required|integer',
            'quiz_id' => 'required|integer',
            'is_live' => 'required|boolean',
            'player_list' => 'nullable|array',
            'pin' => 'required|string|max:10|unique:games',
        ]);

        // Trả về lỗi nếu validation thất bại
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Tạo game mới
        $game = new Game([
            'host_id' => $request->input('host_id'),
            'quiz_id' => $request->input('quiz_id'),
            'pin' => $request->input('pin'),
            'is_live' => $request->input('is_live'),
            'player_list' => json_encode($request->input('player_list', [])),
            'start_date' => now(),
        ]);

        try {
            $game->save();

            // Trả về thông tin game đã tạo
            return response()->json($game, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating game',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function getGames()
    {
        try {
            // Lấy tất cả các game từ cơ sở dữ liệu
            $games = Game::all();
            // Trả về danh sách game với mã trạng thái 200 (OK)
            return response()->json($games, 200);
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có và trả về thông báo lỗi với mã trạng thái 500
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function getGame($id)
    {
        try {
            // Tìm game theo ID
            $game = Game::find($id);

            if ($game === null) {
                // Nếu không tìm thấy game, trả về mã trạng thái 404 (Not Found)
                return response()->json(['message' => 'Game không tồn tại'], 404);
            }

            // Trả về thông tin của game
            return response()->json($game);
        } catch (\Exception $e) {
            // Xử lý lỗi và trả về thông báo lỗi với mã trạng thái 500
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function deleteGame($id)
    {
        try {
            // Tìm game theo ID
            $game = Game::find($id);
            if (!$game) {
                // Nếu game không tồn tại, trả về mã trạng thái 404
                return response()->json(['message' => 'Game không tồn tại'], 404);
            }

            // Xóa game khỏi cơ sở dữ liệu
            $game->delete();
            // Trả về thông báo thành công
            return response()->json(['message' => 'Xóa game thành công'], 200);
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function updateGame(Request $request, $id)
{
    // Xác thực dữ liệu đầu vào
    $validated = $request->validate([
        'host_id' => 'required|integer',
        'quiz_id' => 'required|integer',
        'pin' => 'required|string|max:10',
        'is_live' => 'required|boolean',
        'player_list' => 'nullable|array', // Chấp nhận player_list là một mảng (nếu có)
        'start_date' => 'required|date',
    ]);

    try {
        // Tìm game theo ID
        $game = Game::find($id);
        if (!$game) {
            // Nếu không tìm thấy game, trả về mã trạng thái 404
            return response()->json(['message' => 'Game không tồn tại'], 404);
        }

        // Lấy danh sách kết quả của người chơi liên quan đến game
        $playerResultList = PlayerResult::where('gameId', $id)->get();

        // Cập nhật thông tin game
        $game->update([
            'host_id' => $validated['host_id'],
            'quiz_id' => $validated['quiz_id'],
            'pin' => $validated['pin'],
            'is_live' => $validated['is_live'],
            'player_list' => $validated['player_list'] ?? $game->player_list, // Nếu player_list không có trong request, giữ nguyên
            'start_date' => $validated['start_date'],
        ]);

        // Trả về thông tin game đã được cập nhật
        return response()->json($game, 200);
    } catch (\Exception $e) {
        // Xử lý lỗi nếu có
        return response()->json(['message' => $e->getMessage()], 500);
    }
}

    public function addPlayer(Request $request, $gameId)
    {
        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'playerId' => 'required|integer', // playerId là số nguyên
        ]);

        try {
            // Tìm game theo ID
            $game = Game::find($gameId);

            if (!$game) {
                // Nếu không tìm thấy game, trả về mã trạng thái 404
                return response()->json(['message' => 'Game không tồn tại'], 404);
            }

            // Thêm playerId vào danh sách người chơi
            $player_list = json_decode($game->player_list, true); // Chuyển player_list từ JSON sang mảng
            $player_list[] = $validated['playerId']; // Thêm playerId mới vào mảng

            $game->player_list = json_encode($player_list); // Chuyển lại thành JSON
            $game->save(); // Lưu thay đổi vào cơ sở dữ liệu

            // Trả về thông tin game đã được cập nhật
            return response()->json($game, 200);
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
