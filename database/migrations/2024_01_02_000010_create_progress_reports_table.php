<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('progress_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('report_date');
            $table->integer('week_number')->nullable();
            $table->integer('total_workouts')->default(0);
            $table->integer('total_calories_burned')->default(0);
            $table->integer('total_steps')->default(0);
            $table->decimal('avg_sleep_hours', 3, 1)->default(0);
            $table->decimal('weight_start', 5, 2)->nullable();
            $table->decimal('weight_end', 5, 2)->nullable();
            $table->integer('fitness_score')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progress_reports');
    }
};
