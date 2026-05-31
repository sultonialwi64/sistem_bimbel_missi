<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'student_id',
        'amount',
        'discount',
        'payment_date',
        'due_date',
        'status',
        'payment_method',
        'payment_proof',
        'transaction_id',
        'notes',
        'verified_by',
        'wa_sent_at',
        'wa_sent_by',
        'wa_sent_count',
    ];

    protected function casts(): array
    {
        return [
            'payment_date' => 'date',
            'due_date' => 'date',
            'amount' => 'decimal:2',
            'discount' => 'decimal:2',
            'wa_sent_at' => 'datetime',
            'wa_sent_count' => 'integer',
        ];
    }

    /**
     * Relationships
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function waSentBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'wa_sent_by');
    }

    /**
     * Check if payment is overdue
     */
    public function isOverdue(): bool
    {
        return $this->status !== 'paid' && now()->gt($this->due_date);
    }

    /**
     * Get days until due
     */
    public function getDaysUntilDueAttribute(): int
    {
        return now()->diffInDays($this->due_date, false);
    }

    /**
     * Scope for pending payments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for overdue payments
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue');
    }

    /**
     * Scope for paid payments
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }
}
