<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_id',
        'name',
        'sets',
        'reps',
        'weight',
        'duration_seconds',
        'rest_seconds',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'sets' => 'integer',
            'reps' => 'integer',
            'weight' => 'decimal:2',
            'duration_seconds' => 'integer',
            'rest_seconds' => 'integer',
        ];
    }

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }
}
