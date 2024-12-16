<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PlayerResultStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'player_result_id',
        'player_id',
        'average_time_per_question',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function playerResult()
    {
        return $this->belongsTo(PlayerResult::class, 'player_result_id');
    }

    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }
}
