<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Tutor, Subject};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TutorController extends Controller
{
    public function index()
    {
        $tutors = Tutor::with('user')->latest()->paginate(10);
        return view('admin.tutors.index', compact('tutors'));
    }

    public function create()
    {
        $subjects = Subject::orderBy('name')->pluck('name');
        return view('admin.tutors.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
            'specialization' => ['required', 'array', 'min:1'],
            'specialization.*' => ['string', 'max:100'],
            'bio' => ['nullable', 'string'],
            'education' => ['nullable', 'string'],
            'bank_account' => ['nullable', 'string'],
            'bank_name' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'tutor',
            'phone' => $validated['phone'],
            'is_active' => true,
        ]);

        Tutor::create([
            'user_id' => $user->id,
            'specialization' => $validated['specialization'],
            'bio' => $validated['bio'] ?? null,
            'education' => $validated['education'] ?? null,
            'bank_account' => $validated['bank_account'] ?? null,
            'bank_name' => $validated['bank_name'] ?? null,
        ]);

        return redirect()->route('admin.tutors.index')
            ->with('success', 'Tutor berhasil ditambahkan!');
    }

    public function show(Tutor $tutor)
    {
        $tutor->load(['user', 'schedules', 'salaries']);
        return view('admin.tutors.show', compact('tutor'));
    }

    public function edit(Tutor $tutor)
    {
        $subjects = Subject::orderBy('name')->pluck('name');
        return view('admin.tutors.edit', compact('tutor', 'subjects'));
    }

    public function update(Request $request, Tutor $tutor)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($tutor->user_id)],
            'password' => ['nullable', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
            'specialization' => ['required', 'array', 'min:1'],
            'specialization.*' => ['string', 'max:100'],
            'status' => ['required', Rule::in(['active', 'inactive', 'suspended'])],
            'bio' => ['nullable', 'string'],
            'education' => ['nullable', 'string'],
            'bank_account' => ['nullable', 'string'],
            'bank_name' => ['nullable', 'string'],
        ]);

        $tutor->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        if (!empty($validated['password'])) {
            $tutor->user->password = bcrypt($validated['password']);
            $tutor->user->save();
        }

        $tutor->update([
            'specialization' => $validated['specialization'],
            'status' => $validated['status'],
            'bio' => $validated['bio'] ?? null,
            'education' => $validated['education'] ?? null,
            'bank_account' => $validated['bank_account'] ?? null,
            'bank_name' => $validated['bank_name'] ?? null,
        ]);

        return redirect()->route('admin.tutors.index')
            ->with('success', 'Data tutor berhasil diupdate!');
    }

    public function destroy(Tutor $tutor)
    {
        $tutor->delete();
        return redirect()->route('admin.tutors.index')
            ->with('success', 'Tutor berhasil dihapus!');
    }
}
