<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitnessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'log_date',
        'steps',
        'water_intake_ml',
        'calories_consumed',
        'calories_burned',
        'sleep_hours',
        'weight',
        'heart_rate',
        'mood',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'log_date' => 'date',
            'steps' => 'integer',
            'water_intake_ml' => 'integer',
            'calories_consumed' => 'integer',
            'calories_burned' => 'integer',
            'sleep_hours' => 'decimal:1',
            'weight' => 'decimal:2',
            'heart_rate' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
