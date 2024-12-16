<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasFactory,HasApiTokens;

    protected $fillable = [
        'first_name',
        'last_name',
        'user_name',
        'mail',
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function games()
    {
        return $this->hasMany(Game::class, 'host_id');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'creator_id');
    }
}

