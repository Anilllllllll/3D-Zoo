<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * QuizResult Model - ZooSphere
 * Tracks user quiz scores and attempts
 */
class QuizResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'score',
        'total',
        'percentage',
    ];

    /**
     * Get the user who took the quiz
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
