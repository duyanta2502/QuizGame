<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GameStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'player_result_list',
        'average_time_per_question',
        'average_points_per_question',
    ];

    protected $casts = [
        'player_result_list' => 'array',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}
