<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'name',
        'birth_date',
        'school_name',
        'grade_level',
        'photo',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relationships
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function sessionReports(): HasMany
    {
        return $this->hasMany(SessionReport::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function progress(): HasMany
    {
        return $this->hasMany(StudentProgress::class);
    }

    public function qualityAssessments(): HasMany
    {
        return $this->hasMany(QualityAssessment::class);
    }

    public function latestProgress()
    {
        return $this->hasOne(StudentProgress::class)->latest('assessment_date');
    }

    /**
     * Get student age
     */
    public function getAgeAttribute(): int
    {
        if (!$this->birth_date) {
            return 0;
        }
        return $this->birth_date->age;
    }

    /**
     * Scope for active students
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
