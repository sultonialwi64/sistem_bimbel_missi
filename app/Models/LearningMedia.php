<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningMedia extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'file_path',
        'url',
        'thumbnail_path',
        'is_premium',
        'is_active',
    ];

    protected $casts = [
        'is_premium' => 'boolean',
        'is_active' => 'boolean',
    ];
}
