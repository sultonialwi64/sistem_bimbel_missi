<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GradeLevel;
use Illuminate\Http\Request;

class GradeLevelController extends Controller
{
    public function index()
    {
        $gradeLevels = GradeLevel::withCount('subjects')->latest()->paginate(10);
        return view('admin.grade_levels.index', compact('gradeLevels'));
    }

    public function create()
    {
        return view('admin.grade_levels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:grade_levels,name'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        GradeLevel::create($validated);

        return redirect()->route('admin.grade-levels.index')
            ->with('success', 'Jenjang berhasil ditambahkan!');
    }

    public function edit(GradeLevel $gradeLevel)
    {
        return view('admin.grade_levels.edit', compact('gradeLevel'));
    }

    public function update(Request $request, GradeLevel $gradeLevel)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:grade_levels,name,' . $gradeLevel->id],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $gradeLevel->update($validated);

        return redirect()->route('admin.grade-levels.index')
            ->with('success', 'Jenjang berhasil diperbarui!');
    }

    public function destroy(GradeLevel $gradeLevel)
    {
        if ($gradeLevel->subjects()->count() > 0) {
            return back()->with('error', 'Tidak bisa menghapus jenjang yang masih memiliki mata pelajaran!');
        }

        $gradeLevel->delete();
        return redirect()->route('admin.grade-levels.index')
            ->with('success', 'Jenjang berhasil dihapus!');
    }
}
