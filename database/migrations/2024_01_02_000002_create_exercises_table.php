<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('sets')->default(0);
            $table->integer('reps')->default(0);
            $table->decimal('weight', 6, 2)->nullable();
            $table->integer('duration_seconds')->default(0);
            $table->integer('rest_seconds')->default(30);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
