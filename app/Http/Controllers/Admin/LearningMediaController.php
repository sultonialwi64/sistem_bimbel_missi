<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LearningMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LearningMediaController extends Controller
{
    public function index()
    {
        $media = LearningMedia::latest()->paginate(10);
        return view('admin.learning-media.index', compact('media'));
    }

    public function create()
    {
        return view('admin.learning-media.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:pdf,video,web_game',
            'category' => 'required|string|max:100',
            'is_premium' => 'boolean',
            'is_active' => 'boolean',
            'file' => 'nullable|file|mimes:pdf|max:10240', // 10MB limit
            'url' => 'nullable|url|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'type', 'category']);
        $data['is_premium'] = $request->has('is_premium');
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('file') && $data['type'] === 'pdf') {
            $data['file_path'] = $request->file('file')->store('learning-media/files', 'public');
        } elseif ($request->filled('url')) {
            $data['url'] = $request->url;
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = $request->file('thumbnail')->store('learning-media/thumbnails', 'public');
        }

        LearningMedia::create($data);

        return redirect()->route('admin.learning-media.index')->with('success', 'Media belajar berhasil ditambahkan.');
    }

    public function show(LearningMedia $learningMedia)
    {
        return view('admin.learning-media.show', compact('learningMedia'));
    }

    public function edit(LearningMedia $learningMedia)
    {
        return view('admin.learning-media.edit', compact('learningMedia'));
    }

    public function update(Request $request, LearningMedia $learningMedia)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:pdf,video,web_game',
            'category' => 'required|string|max:100',
            'is_premium' => 'boolean',
            'is_active' => 'boolean',
            'file' => 'nullable|file|mimes:pdf|max:10240',
            'url' => 'nullable|url|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'type', 'category']);
        $data['is_premium'] = $request->has('is_premium');
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('file') && $data['type'] === 'pdf') {
            if ($learningMedia->file_path) {
                Storage::disk('public')->delete($learningMedia->file_path);
            }
            $data['file_path'] = $request->file('file')->store('learning-media/files', 'public');
        } elseif ($request->filled('url')) {
            $data['url'] = $request->url;
        }

        if ($request->hasFile('thumbnail')) {
            if ($learningMedia->thumbnail_path) {
                Storage::disk('public')->delete($learningMedia->thumbnail_path);
            }
            $data['thumbnail_path'] = $request->file('thumbnail')->store('learning-media/thumbnails', 'public');
        }

        $learningMedia->update($data);

        return redirect()->route('admin.learning-media.index')->with('success', 'Media belajar berhasil diperbarui.');
    }

    public function destroy(LearningMedia $learningMedia)
    {
        if ($learningMedia->file_path) {
            Storage::disk('public')->delete($learningMedia->file_path);
        }
        
        if ($learningMedia->thumbnail_path) {
            Storage::disk('public')->delete($learningMedia->thumbnail_path);
        }
        
        $learningMedia->delete();

        return redirect()->route('admin.learning-media.index')->with('success', 'Media belajar berhasil dihapus.');
    }
}
