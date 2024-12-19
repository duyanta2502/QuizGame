<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Leaderboard;
use App\Models\Game;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LeaderboardController extends Controller
{

    //Tạo một bảng xếp hạng mới cho một game.
    public function createLeaderboard(Request $request)
    {
        $validated = $request->validate([
            'gameId' => 'required|integer',
            'playerResultList' => 'required|array',
        ]);

        // Lấy thông tin game và quiz từ cơ sở dữ liệu
        $game = Game::find($validated['gameId']);
        $quiz = Quiz::find($game->quizId);

        // Tạo leaderboard mới
        $leaderboard = new Leaderboard([
            'gameId' => $validated['gameId'],
            'playerResultList' => json_encode($validated['playerResultList']), // Lưu danh sách kết quả người chơi dưới dạng JSON
        ]);

        // Thêm thông tin các câu hỏi vào leaderboard
        foreach ($quiz->questionList as $question) {
            $leaderboard->questionLeaderboard[] = [
                'questionIndex' => $question->questionIndex,
                'questionResultList' => [],
            ];
            $leaderboard->currentLeaderboard[] = [
                'questionIndex' => $question->questionIndex,
                'leaderboardList' => [],
            ];
        }

        try {
            $leaderboard->save();
            return response()->json($leaderboard, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    //Lấy thông tin của một bảng xếp hạng theo ID.
    public function getLeaderboard($id)
    {
        try {
            // Tìm leaderboard theo ID
            $leaderboard = Leaderboard::find($id);

            if ($leaderboard === null) {
                // Nếu không tìm thấy leaderboard, trả về mã trạng thái 404
                return response()->json(['message' => 'Leaderboard không tồn tại'], 404);
            }

            return response()->json($leaderboard);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    //Thêm kết quả của một người chơi vào bảng xếp hạng.
    public function addPlayerResult(Request $request, $leaderboardId)
    {
        $validated = $request->validate([
            'playerResultId' => 'required|integer',
        ]);

        try {
            // Tìm leaderboard theo ID
            $leaderboard = Leaderboard::find($leaderboardId);
            if (!$leaderboard) {
                return response()->json(['message' => 'Leaderboard không tồn tại'], 404);
            }

            // Thêm kết quả người chơi vào danh sách playerResultList
            $playerResultList = json_decode($leaderboard->playerResultList, true); // Chuyển danh sách từ JSON thành mảng
            $playerResultList[] = $validated['playerResultId']; // Thêm kết quả vào danh sách
            $leaderboard->playerResultList = json_encode($playerResultList); // Chuyển lại thành JSON

            $leaderboard->save();

            return response()->json($leaderboard, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    //Cập nhật kết quả của người chơi cho một câu hỏi cụ thể trong bảng xếp hạng.
    public function updateQuestionLeaderboard(Request $request, $leaderboardId)
    {
        $validated = $request->validate([
            'questionIndex' => 'required|integer',
            'playerId' => 'required|integer',
            'playerPoints' => 'required|integer',
        ]);

        try {
            // Tìm leaderboard theo ID
            $leaderboard = Leaderboard::find($leaderboardId);
            if (!$leaderboard) {
                return response()->json(['message' => 'Leaderboard không tồn tại'], 404);
            }

            // Cập nhật kết quả câu hỏi
            $questionIndex = $validated['questionIndex'] - 1; // Chỉ số câu hỏi bắt đầu từ 0
            $questionLeaderboard = json_decode($leaderboard->questionLeaderboard, true);
            $questionLeaderboard[$questionIndex]['questionResultList'][] = [
                'playerId' => $validated['playerId'],
                'playerPoints' => $validated['playerPoints'],
            ];
            $leaderboard->questionLeaderboard = json_encode($questionLeaderboard);

            $leaderboard->save();

            return response()->json($leaderboard, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }


    //Cập nhật bảng xếp hạng hiện tại của người chơi theo câu hỏi
    public function updateCurrentLeaderboard(Request $request, $leaderboardId)
    {
        $validated = $request->validate([
            'questionIndex' => 'required|integer',
            'playerId' => 'required|integer',
            'playerCurrentScore' => 'required|integer',
        ]);

        try {
            // Tìm leaderboard theo ID
            $leaderboard = Leaderboard::find($leaderboardId);
            if (!$leaderboard) {
                return response()->json(['message' => 'Leaderboard không tồn tại'], 404);
            }

            // Cập nhật bảng leaderboard hiện tại
            $questionIndex = $validated['questionIndex'] - 1; // Chỉ số câu hỏi bắt đầu từ 0
            $currentLeaderboard = json_decode($leaderboard->currentLeaderboard, true);
            $currentLeaderboard[$questionIndex]['leaderboardList'][] = [
                'playerId' => $validated['playerId'],
                'playerCurrentScore' => $validated['playerCurrentScore'],
            ];
            $leaderboard->currentLeaderboard = json_encode($currentLeaderboard);

            $leaderboard->save();

            return response()->json($leaderboard, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
