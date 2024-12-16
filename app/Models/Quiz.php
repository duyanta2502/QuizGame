<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'background_image',
        'creator_id',
        'points_per_question',
        'number_of_questions',
        'is_public',
        'tags',
        'likes_count',
        'comments_count',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
