<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'tutor_id',
        'assessment_date',
        'skill_areas',
        'overall_score',
        'improvement_notes',
        'recommendations',
        'level_achieved',
    ];

    protected function casts(): array
    {
        return [
            'assessment_date' => 'date',
            'skill_areas' => 'array',
            'overall_score' => 'integer',
        ];
    }

    /**
     * Relationships
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }

    /**
     * Get level badge color
     */
    public function getLevelBadgeColorAttribute(): string
    {
        return match($this->level_achieved) {
            'advanced' => 'bg-green-500',
            'intermediate' => 'bg-yellow-500',
            'beginner' => 'bg-red-500',
            default => 'bg-gray-500',
        };
    }

    /**
     * Scope by latest assessment
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('assessment_date', 'desc');
    }

    /**
     * Get progress trend (compared to previous assessment)
     */
    public function getTrendAttribute(): string
    {
        $previous = static::where('student_id', $this->student_id)
            ->where('subject_id', $this->subject_id)
            ->where('id', '!=', $this->id)
            ->latest('assessment_date')
            ->first();

        if (!$previous) {
            return 'new';
        }

        if ($this->overall_score > $previous->overall_score) {
            return 'improving';
        } elseif ($this->overall_score < $previous->overall_score) {
            return 'declining';
        } else {
            return 'stable';
        }
    }
}
