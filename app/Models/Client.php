<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'emergency_contact',
        'client_type',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relationships
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get full address with coordinates
     */
    public function getFullAddressAttribute(): string
    {
        return $this->address;
    }

    /**
     * Get price based on client type
     */
    public function getSessionPriceAttribute(): int
    {
        return $this->client_type === 'tipe_1' ? 45000 : 50000;
    }

    /**
     * Get company margin based on client type
     */
    public function getCompanyMarginAttribute(): int
    {
        return $this->client_type === 'tipe_1' ? 5000 : 10000;
    }

    /**
     * Get flat monthly discount amount based on client type
     */
    public function getDiscountAttribute(): int
    {
        return $this->client_type === 'tipe_1'
            ? config('bimbel.discount.tipe_1', 10000)
            : config('bimbel.discount.tipe_2', 20000);
    }
}
