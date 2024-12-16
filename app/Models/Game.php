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
        'pin',
        'is_live',
        'player_list',
    ];

    protected $casts = [
        'player_list' => 'array',
    ];

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}
