<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'meal_type',
        'calories',
        'protein_g',
        'carbs_g',
        'fat_g',
        'fiber_g',
        'is_healthy',
        'image_url',
    ];

    protected function casts(): array
    {
        return [
            'calories' => 'integer',
            'protein_g' => 'decimal:1',
            'carbs_g' => 'decimal:1',
            'fat_g' => 'decimal:1',
            'fiber_g' => 'decimal:1',
            'is_healthy' => 'boolean',
        ];
    }
}
