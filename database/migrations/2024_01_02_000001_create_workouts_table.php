<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('category'); // cardio, strength, yoga, sports
            $table->text('description')->nullable();
            $table->integer('duration_minutes')->default(0);
            $table->integer('calories_burned')->default(0);
            $table->string('intensity')->default('moderate'); // low, moderate, high
            $table->boolean('completed')->default(false);
            $table->date('workout_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workouts');
    }
};
