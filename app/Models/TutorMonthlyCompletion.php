<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorMonthlyCompletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_id',
        'student_id',
        'period_start',
        'is_completed',
        'completed_at',
    ];

    protected $casts = [
        'period_start' => 'date',
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
