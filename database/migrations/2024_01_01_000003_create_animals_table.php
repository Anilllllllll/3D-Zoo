<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for animals table
 * Stores comprehensive animal profiles for the virtual zoo
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('species');
            $table->string('scientific_name');
            $table->string('category'); // mammal, bird, reptile, fish, etc.
            $table->foreignId('habitat_id')->constrained()->onDelete('cascade');
            $table->string('diet'); // carnivore, herbivore, omnivore
            $table->string('lifespan');
            $table->string('conservation_status'); // endangered, vulnerable, least concern, etc.
            $table->text('description');
            $table->string('image')->nullable();
            $table->json('gallery')->nullable(); // array of image URLs
            $table->string('sound')->nullable(); // audio file path
            $table->json('fun_facts')->nullable(); // array of fun facts
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->string('speed')->nullable();
            $table->integer('views_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
