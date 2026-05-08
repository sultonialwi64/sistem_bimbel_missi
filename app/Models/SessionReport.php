<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'tutor_id',
        'student_id',
        'material_covered',
        'student_understanding',
        'notes_for_parent',
        'tutor_rating_by_student',
        'parent_rating',
        'parent_feedback',
    ];

    protected function casts(): array
    {
        return [
            'student_understanding' => 'integer',
            'tutor_rating_by_student' => 'integer',
            'parent_rating' => 'integer',
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

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get understanding level as text
     */
    public function getUnderstandingLevelAttribute(): string
    {
        $level = $this->student_understanding;

        if ($level >= 5) {
            return 'Excellent';
        } elseif ($level >= 4) {
            return 'Good';
        } elseif ($level >= 3) {
            return 'Fair';
        } elseif ($level >= 2) {
            return 'Poor';
        } else {
            return 'Very Poor';
        }
    }

    /**
     * Scope by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }
}
