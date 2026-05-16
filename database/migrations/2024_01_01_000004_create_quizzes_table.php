<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for quizzes table
 * Stores wildlife quiz questions with multiple choice options
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->json('options'); // array of 4 options
            $table->string('correct_answer');
            $table->string('difficulty')->default('medium'); // easy, medium, hard
            $table->string('category')->nullable(); // animal category for filtering
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
