<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_id',
        'period_start',
        'period_end',
        'total_sessions',
        'base_salary',
        'bonus',
        'bonus_reason',
        'deduction',
        'deduction_reason',
        'total_amount',
        'status',
        'payment_date',
        'payment_proof',
        'approved_by',
    ];

    protected function casts(): array
    {
        return [
            'period_start' => 'date',
            'period_end' => 'date',
            'payment_date' => 'date',
            'base_salary' => 'decimal:2',
            'bonus' => 'decimal:2',
            'deduction' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ];
    }

    /**
     * Relationships
     */
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Calculate base salary from sessions
     */
    public function calculateBaseSalary(): void
    {
        $ratePerSession = config('bimbel.salary.session_rate_tutor', 40000);
        $this->base_salary = $this->total_sessions * $ratePerSession;
    }

    /**
     * Calculate total amount
     */
    public function calculateTotal(): void
    {
        $this->calculateBaseSalary();
        $this->total_amount = $this->base_salary + $this->bonus - $this->deduction;
    }

    /**
     * Scope for pending salaries
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for paid salaries
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Check if salary is for current period
     */
    public function isCurrentPeriod(): bool
    {
        $now = now();

        return $now >= $this->period_start && $now <= $this->period_end;
    }
}
