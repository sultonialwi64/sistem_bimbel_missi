<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'tutor_id',
        'photo_path',
        'captured_at',
        'verification_status',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'captured_at' => 'datetime',
        ];
    }

    /**
     * Relationships
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }

    /**
     * Check if tutor is late (more than 15 minutes)
     */
    public function isLate(int $gracePeriod = 15): bool
    {
        if (!$this->captured_at || !$this->schedule) {
            return false;
        }

        $scheduledTime = \Carbon\Carbon::parse($this->schedule->start_time);
        $actualTime = $this->captured_at;

        return $actualTime->diffInMinutes($scheduledTime) > $gracePeriod;
    }

    /**
     * Scope for present attendances
     */
    public function scopePresent($query)
    {
        return $query->whereIn('status', ['hadir', 'pindah_lokasi']);
    }

    /**
     * Scope for today's attendances
     */
    public function scopeToday($query)
    {
        return $query->whereDate('captured_at', today());
    }
}
