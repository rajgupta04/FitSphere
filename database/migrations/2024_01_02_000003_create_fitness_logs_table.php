<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fitness_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('log_date');
            $table->integer('steps')->default(0);
            $table->integer('water_intake_ml')->default(0);
            $table->integer('calories_consumed')->default(0);
            $table->integer('calories_burned')->default(0);
            $table->decimal('sleep_hours', 3, 1)->default(0);
            $table->decimal('weight', 5, 2)->nullable();
            $table->integer('heart_rate')->nullable();
            $table->string('mood')->nullable(); // great, good, neutral, bad, terrible
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'log_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fitness_logs');
    }
};
