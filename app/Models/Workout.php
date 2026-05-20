<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'category',
        'description',
        'duration_minutes',
        'calories_burned',
        'intensity',
        'completed',
        'workout_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'workout_date' => 'date',
            'completed' => 'boolean',
            'calories_burned' => 'integer',
            'duration_minutes' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }

    /**
     * Scope for filtering by category.
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
