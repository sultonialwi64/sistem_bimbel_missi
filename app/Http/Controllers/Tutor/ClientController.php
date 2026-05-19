<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\{User, Client};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('user')->latest()->paginate(10);
        return view('tutor.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('tutor.clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'emergency_contact' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'client',
            'phone' => $validated['phone'],
            'is_active' => true,
        ]);

        Client::create([
            'user_id' => $user->id,
            'address' => $validated['address'],
            'emergency_contact' => $validated['emergency_contact'] ?? null,
        ]);

        return redirect()->route('tutor.clients.index')
            ->with('success', 'Client berhasil ditambahkan!');
    }

    public function show(Client $client)
    {
        $client->load(['user', 'students', 'payments']);
        return view('tutor.clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('tutor.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($client->user_id)],
            'password' => ['nullable', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'emergency_contact' => ['nullable', 'string', 'max:20'],
        ]);

        $client->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        if (!empty($validated['password'])) {
            $client->user->password = bcrypt($validated['password']);
            $client->user->save();
        }

        $client->update([
            'address' => $validated['address'],
            'emergency_contact' => $validated['emergency_contact'] ?? null,
        ]);

        return redirect()->route('tutor.clients.index')
            ->with('success', 'Data client berhasil diupdate!');
    }

    public function destroy(Client $client)
    {
        $user = $client->user;
        $client->delete();
        if ($user) {
            $user->delete();
        }
        
        return redirect()->route('tutor.clients.index')
            ->with('success', 'Client dan akun login berhasil dihapus!');
    }
}
