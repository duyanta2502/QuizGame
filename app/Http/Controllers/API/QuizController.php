<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    // Tạo mới một quiz
    public function createQuiz(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150|unique:quizzes,name',
            'background_image' => 'nullable|string',
            'description' => 'nullable|string',
            'points_per_question' => 'required|integer',
            'question_list' => 'required|array',
        ]);

        $quiz = Quiz::create([
            'name' => $validated['name'],
            'background_image' => $validated['background_image'],
            'description' => $validated['description'],
            'creator_id' => Auth::id(), // Người tạo quiz
            'points_per_question' => $validated['points_per_question'],
            'question_list' => $validated['question_list'], // Model sẽ cast sang JSON
        ]);

        return response()->json($quiz, 201);
    }
    // Lấy danh sách tất cả quiz
    public function getQuizzes()
    {
        return response()->json(Quiz::all(), 200);
    }

    // Lấy danh sách quiz công khai (có phân trang)
    // public function getPublicQuizzes(Request $request)
    // {
    //     $limit = 6;
    //     $page = $request->query('page', 1);
    //     $quizzes = Quiz::where('is_public', true)
    //         ->orderBy('created_at', 'desc')
    //         ->paginate($limit, ['*'], 'page', $page);

    //     return response()->json($quizzes, 200);
    // }

    // Lấy danh sách quiz theo ID của giáo viên (creatorId)
    // public function getTeacherQuizzes($teacherId)
    // {
    //     try {
    //         $quizzes = Quiz::where('creatorId', $teacherId)->get(); // Lấy tất cả quiz của giáo viên
    //         return response()->json($quizzes, 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => $e->getMessage()], 500); // Lỗi 500 nếu có lỗi
    //     }
    // }

    //Lấy chi tiết một quiz theo ID

    public function getQuiz($id)
    {
        try {
            $quiz = Quiz::findOrFail($id); // Tìm quiz theo ID, nếu không tìm thấy sẽ lỗi 404
            return response()->json($quiz, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404); // Lỗi nếu không tìm thấy quiz
        }
    }

    // Xóa quiz theo ID
    public function deleteQuiz($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return response()->json(['message' => 'Quiz deleted successfully'], 200);
    }

    // Cập nhật quiz theo ID
    public function updateQuiz(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'background_image' => 'nullable|string',
            'description' => 'nullable|string',
            'points_per_question' => 'required|integer',
            'question_list' => 'required|array',
        ]);

        $quiz = Quiz::findOrFail($id);
        $quiz->update($validated);

        return response()->json($quiz, 200);
    }

    // Thêm câu hỏi vào quiz
    public function addQuestion(Request $request, $quizId)
    {
        $validated = $request->validate([
            'question_type' => 'required|string',
            'question' => 'required|string',
            'point_type' => 'required|string',
            'answer_time' => 'required|integer',
            'answer_list' => 'required|array',
            'correct_answers_list' => 'required|array',
        ]);

        $quiz = Quiz::findOrFail($quizId);
        $questions = $quiz->question_list; // Lấy danh sách câu hỏi từ Accessor
        $questions[] = $validated; // Thêm câu hỏi mới
        $quiz->question_list = $questions; // Gán lại giá trị

        $quiz->save();

        return response()->json($quiz, 200);
    }
    // Lấy danh sách câu hỏi của quiz
    public function getQuestions($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        return response()->json($quiz->questions, 200); // Sử dụng Accessor từ Model
    }

    // Tìm kiếm quiz theo tên hoặc tag
    // public function searchQuizzes(Request $request)
    // {
    //     $validated = $request->validate([
    //         'searchQuery' => 'required|string',
    //     ]);

    //     $quizzes = Quiz::where('is_public', true)
    //         ->where('name', 'like', '%' . $validated['searchQuery'] . '%')
    //         ->get();

    //     return response()->json($quizzes, 200);
    // }
}
