<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DietLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'log_date',
        'meal_type',
        'food_name',
        'calories',
        'protein_g',
        'carbs_g',
        'fat_g',
        'fiber_g',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'log_date' => 'date',
            'calories' => 'integer',
            'protein_g' => 'decimal:1',
            'carbs_g' => 'decimal:1',
            'fat_g' => 'decimal:1',
            'fiber_g' => 'decimal:1',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
