<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for habitats table
 * Stores wildlife habitat information (Forest, Desert, Ocean, Arctic, Savannah)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('habitats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('climate')->nullable();
            $table->string('region')->nullable();
            $table->string('icon')->default('🌍');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('habitats');
    }
};
