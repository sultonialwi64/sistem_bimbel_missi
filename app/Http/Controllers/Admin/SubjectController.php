<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\GradeLevel;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('gradeLevel')->latest()->paginate(10);
        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        $levels = GradeLevel::all();
        return view('admin.subjects.create', compact('levels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'description'    => ['nullable', 'string'],
            'grade_level_id' => ['required', 'exists:grade_levels,id'],
            'is_active'      => ['boolean'],
        ]);

        Subject::create($validated);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }

    public function show(Subject $subject)
    {
        $subject->load(['gradeLevel', 'schedules', 'studentProgress']);
        return view('admin.subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        $levels = GradeLevel::all();
        return view('admin.subjects.edit', compact('subject', 'levels'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'description'    => ['nullable', 'string'],
            'grade_level_id' => ['required', 'exists:grade_levels,id'],
            'is_active'      => ['boolean'],
        ]);

        $subject->update($validated);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Mata pelajaran berhasil diupdate!');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('admin.subjects.index')
            ->with('success', 'Mata pelajaran berhasil dihapus!');
    }
}
