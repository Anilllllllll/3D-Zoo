<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Quiz Model - ZooSphere
 * Represents wildlife quiz questions with multiple choice options
 */
class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'options',
        'correct_answer',
        'difficulty',
        'category',
    ];

    /**
     * Cast JSON fields
     */
    protected function casts(): array
    {
        return [
            'options' => 'array',
        ];
    }
}
