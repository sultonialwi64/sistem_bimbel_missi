<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QualityAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_id',
        'student_id',
        'schedule_id',
        'criteria_scores',
        'overall_score',
        'feedback_text',
        'assessed_by',
        'assessor_id',
        'is_positive',
        'requires_followup',
    ];

    protected function casts(): array
    {
        return [
            'criteria_scores' => 'array',
            'overall_score' => 'integer',
            'is_positive' => 'boolean',
            'requires_followup' => 'boolean',
        ];
    }

    /**
     * Relationships
     */
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function assessor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assessor_id');
    }

    /**
     * Get average criteria score
     */
    public function getAverageCriteriaScoreAttribute(): float
    {
        if (empty($this->criteria_scores)) {
            return 0;
        }
        return array_sum($this->criteria_scores) / count($this->criteria_scores);
    }

    /**
     * Check if assessment is positive (score >= 4)
     */
    public function updatePositiveFlag(): void
    {
        $this->is_positive = $this->overall_score >= 4;
        $this->requires_followup = $this->overall_score < 3;
    }

    /**
     * Scope for positive assessments
     */
    public function scopePositive($query)
    {
        return $query->where('is_positive', true);
    }

    /**
     * Scope for assessments requiring followup
     */
    public function scopeRequiresFollowup($query)
    {
        return $query->where('requires_followup', true);
    }

    /**
     * Scope by assessed_by type
     */
    public function scopeByAssessedBy($query, string $type)
    {
        return $query->where('assessed_by', $type);
    }
}
