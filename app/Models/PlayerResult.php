<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PlayerResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'game_id',
        'score',
        'answers',
    ];

    protected $casts = [
        'answers' => 'array',
    ];

    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}
