<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tutor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
        'session_rate',
        'rating_avg',
        'total_sessions',
        'status',
        'bank_account',
        'bank_name',
        'bio',
        'education',
        'certificate',
    ];

    protected function casts(): array
    {
        return [
            'specialization' => 'array',
            'session_rate' => 'decimal:2',
            'rating_avg' => 'decimal:2',
        ];
    }

    /**
     * Relationships
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function sessionReports(): HasMany
    {
        return $this->hasMany(SessionReport::class);
    }

    public function salaries(): HasMany
    {
        return $this->hasMany(Salary::class);
    }

    public function studentProgress(): HasMany
    {
        return $this->hasMany(StudentProgress::class);
    }

    public function qualityAssessments(): HasMany
    {
        return $this->hasMany(QualityAssessment::class);
    }

    /**
     * Get tutor tier based on rating
     */
    public function getTierAttribute(): string
    {
        if ($this->rating_avg >= 4.8) {
            return 'Master Tutor';
        } elseif ($this->rating_avg >= 4.5) {
            return 'Senior Tutor';
        } elseif ($this->rating_avg >= 4.0) {
            return 'Regular Tutor';
        } else {
            return 'Junior Tutor';
        }
    }

    /**
     * Scope for active tutors
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
