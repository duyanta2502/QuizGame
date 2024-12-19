<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quizzes'; // Tên bảng trong cơ sở dữ liệu

    protected $fillable = [
        'name',
        'description',
        'background_image',
        'creator_id',
        'points_per_question',
        'number_of_questions',
        'question_list',
    ];

    protected $casts = [
        'question_list' => 'array', // Tự động chuyển JSON thành mảng khi truy cập
    ];

    /**
     * Quan hệ với bảng users (người tạo quiz).
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Quan hệ với bảng games (quiz được sử dụng trong các game).
     */
    public function games()
    {
        return $this->hasMany(Game::class, 'quiz_id');
    }

    /**
     * Lấy danh sách câu hỏi dưới dạng mảng.
     */
    public function getQuestionsAttribute()
    {
        // Nếu question_list là chuỗi JSON, giải mã thành mảng
        if (is_string($this->question_list)) {
            $this->question_list = json_decode($this->question_list, true);
        }

        // Kiểm tra nếu question_list là mảng, trả về mảng đó, nếu không trả về mảng rỗng
        return is_array($this->question_list) ? $this->question_list : [];
    }

    /**
     * Đếm số lượng câu hỏi từ danh sách câu hỏi.
     */
    public function getNumberOfQuestionsAttribute()
    {
        return count($this->getQuestionsAttribute());
    }
}
