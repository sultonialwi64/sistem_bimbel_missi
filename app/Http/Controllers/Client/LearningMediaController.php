<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\LearningMedia;
use Illuminate\Http\Request;

class LearningMediaController extends Controller
{
    public function index(Request $request)
    {
        $query = LearningMedia::where('is_active', true);

        if ($request->filled('category') && $request->category !== 'Semua') {
            $query->where('category', $request->category);
        }

        $media = $query->latest()->paginate(12)->withQueryString();
        
        $categories = ['Semua', 'Calistung', 'Bahasa Inggris', 'Matematika', 'Sains', 'Umum'];
        $currentCategory = $request->category ?? 'Semua';

        return view('client.learning-media.index', compact('media', 'categories', 'currentCategory'));
    }

    public function show(LearningMedia $learningMedia)
    {
        if (!$learningMedia->is_active) {
            abort(404);
        }

        return view('client.learning-media.show', compact('learningMedia'));
    }
}
