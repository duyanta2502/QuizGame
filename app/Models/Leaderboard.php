<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Leaderboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'gameId', 'playerResultList', 'questionLeaderboard', 'currentLeaderboard',
    ];

    protected $casts = [
        'playerResultList' => 'array',
        'questionLeaderboard' => 'array',
        'currentLeaderboard' => 'array',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}
