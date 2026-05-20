<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressReport extends Model
{
    protected $fillable = [
        'user_id',
        'report_date',
        'week_number',
        'total_workouts',
        'total_calories_burned',
        'total_steps',
        'avg_sleep_hours',
        'weight_start',
        'weight_end',
        'fitness_score',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'report_date' => 'date',
            'week_number' => 'integer',
            'total_workouts' => 'integer',
            'total_calories_burned' => 'integer',
            'total_steps' => 'integer',
            'avg_sleep_hours' => 'decimal:1',
            'weight_start' => 'decimal:2',
            'weight_end' => 'decimal:2',
            'fitness_score' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
