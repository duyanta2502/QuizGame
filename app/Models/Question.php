<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'question_txt',
        'answer_1',
        'answer_2',
        'answer_3',
        'answer_4',
        'correct_answer',
        'description',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
