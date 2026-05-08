<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Role checkers
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isTutor(): bool
    {
        return $this->role === 'tutor';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    /**
     * Relationships
     */
    public function tutor(): HasOne
    {
        return $this->hasOne(Tutor::class);
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function schedulesCreated(): HasMany
    {
        return $this->hasMany(Schedule::class, 'created_by');
    }

    public function salariesApproved(): HasMany
    {
        return $this->hasMany(Salary::class, 'approved_by');
    }

    public function paymentsVerified(): HasMany
    {
        return $this->hasMany(Payment::class, 'verified_by');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function qualityAssessments(): HasMany
    {
        return $this->hasMany(QualityAssessment::class, 'assessor_id');
    }
}
