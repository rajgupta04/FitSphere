<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SportsEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'sport_type',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'max_participants',
        'status',
        'created_by',
        'image_url',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'max_participants' => 'integer',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_registrations');
    }

    public function getAvailableSlotsAttribute(): int
    {
        return max(0, $this->max_participants - $this->registrations()->count());
    }

    public function getIsFullAttribute(): bool
    {
        return $this->available_slots === 0;
    }
}
