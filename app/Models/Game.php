<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Game extends Model
{
    protected $table = 'games';

    protected $fillable = [
        'creator_id',
        'game_title',
        'start_time', 
        'code',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($game) {
            $game->code = $game->code ?? Str::random(6); 
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
        
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
