<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'tutor_id',
        'subject_id',
        'date',
        'start_time',
        'end_time',
        'status',
        'notes',
        'created_by',
    ];

    protected static function booted()
    {
        static::created(function ($schedule) {
            self::logActivity($schedule, 'created');
        });

        static::updated(function ($schedule) {
            self::logActivity($schedule, 'updated');
        });

        static::deleted(function ($schedule) {
            self::logActivity($schedule, 'deleted');
        });
    }

    protected static function logActivity($schedule, $action)
    {
        $actor = auth()->user();
        $actorName = $actor ? $actor->name : 'Sistem';
        
        $studentName = $schedule->student->name ?? 'Siswa';
        $time = \Carbon\Carbon::parse($schedule->date)->format('d/m/Y') . ' ' . 
                \Carbon\Carbon::parse($schedule->start_time)->format('H:i');

        $description = match($action) {
            'created' => "{$actorName} membuat jadwal untuk {$studentName} ({$time})",
            'updated' => "{$actorName} mengubah jadwal {$studentName} ({$time})",
            'deleted' => "{$actorName} menghapus jadwal {$studentName} ({$time})",
            default => "Aktivitas pada jadwal {$studentName}"
        };

        \App\Models\ScheduleLog::create([
            'schedule_id' => $schedule->id,
            'user_id' => $actor ? $actor->id : null,
            'action' => $action,
            'description' => $description,
            'changes' => $action === 'updated' ? $schedule->getChanges() : null
        ]);
    }

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
        ];
    }

    /**
     * Relationships
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attendance(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Attendance::class);
    }

    public function sessionReport(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(SessionReport::class);
    }

    /**
     * Scopes
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', today())->where('status', 'scheduled');
    }

    /**
     * Check if schedule is today
     */
    public function isToday(): bool
    {
        return $this->date->isToday();
    }

    /**
     * Get schedule duration in minutes
     */
    public function getDurationAttribute(): int
    {
        $start = \Carbon\Carbon::parse($this->start_time);
        $end = \Carbon\Carbon::parse($this->end_time);
        return $start->diffInMinutes($end);
    }
}
