<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\LearningMedia;
use Illuminate\Http\Request;

class LearningMediaController extends Controller
{
    public function index()
    {
        // Only show active media
        $media = LearningMedia::where('is_active', true)->latest()->paginate(12);
        return view('tutor.learning-media.index', compact('media'));
    }

    public function show(LearningMedia $learningMedia)
    {
        if (!$learningMedia->is_active) {
            abort(404);
        }

        return view('tutor.learning-media.show', compact('learningMedia'));
    }
}
