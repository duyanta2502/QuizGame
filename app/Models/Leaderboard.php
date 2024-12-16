<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Leaderboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'player_result_list',
        'question_leaderboard',
    ];

    protected $casts = [
        'player_result_list' => 'array',
        'question_leaderboard' => 'array',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}
