<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'host_id',
        'quiz_id',
        'start_date',
        'pin',
        'is_live',
        'player_list',
        'player_result_list',
    ];

    protected $casts = [
        'playerList' => 'array', // Cast playerList thành mảng
        'playerResultList' => 'array', // Cast playerResultList thành mảng
    ];

    // Quan hệ với PlayerResult
    public function playerResults()
    {
        return $this->hasMany(PlayerResult::class);
    }
    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}
