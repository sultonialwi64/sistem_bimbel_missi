<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\{User, Client};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $clients = Client::with('user')
            ->when($search, function($query) use ($search) {
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
            
        return view('tutor.clients.index', compact('clients', 'search'));
    }

    public function create()
    {
        return view('tutor.clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'          => ['required', 'string', 'min:8'],
            'phone'             => ['nullable', 'string', 'max:20'],
            'address'           => ['required', 'string'],
            'emergency_contact' => ['nullable', 'string', 'max:20'],
            'client_type'       => ['required', 'in:tipe_1,tipe_2'],
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
            'user_id'           => $user->id,
            'address'           => $validated['address'],
            'emergency_contact' => $validated['emergency_contact'] ?? null,
            'client_type'       => $validated['client_type'],
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
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($client->user_id)],
            'password'          => ['nullable', 'string', 'min:8'],
            'phone'             => ['nullable', 'string', 'max:20'],
            'address'           => ['required', 'string'],
            'emergency_contact' => ['nullable', 'string', 'max:20'],
            'client_type'       => ['required', 'in:tipe_1,tipe_2'],
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
            'address'           => $validated['address'],
            'emergency_contact' => $validated['emergency_contact'] ?? null,
            'client_type'       => $validated['client_type'],
        ]);

        if ($client->wasChanged('client_type')) {
            $pendingPayments = \App\Models\Payment::where('client_id', $client->id)
                ->where('status', 'pending')
                ->get();
                
            $pricePerSession = $client->session_price;

            foreach ($pendingPayments as $payment) {
                $periodEnd = \Carbon\Carbon::parse($payment->due_date)->subDays(7)->endOfDay();
                $periodStart = $periodEnd->copy()->startOfMonth();
                
                $sessionCount = \App\Models\Schedule::where('student_id', $payment->student_id)
                    ->whereBetween('date', [$periodStart, $periodEnd])
                    ->whereHas('attendance', function ($query) {
                        $query->whereIn('status', ['hadir', 'pindah_lokasi']);
                    })
                    ->count();
                    
                if ($sessionCount > 0) {
                    $payment->update(['amount' => $sessionCount * $pricePerSession]);
                } elseif (preg_match('/\((\d+)\s*sesi\)/i', $payment->notes, $matches)) {
                    $payment->update(['amount' => (int)$matches[1] * $pricePerSession]);
                }
            }
        }

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
