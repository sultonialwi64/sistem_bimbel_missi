<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Client, Student, GradeLevel};
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $statusFilter = $request->input('status', 'active');
        
        $clients = Client::with(['user', 'students'])
            ->when($statusFilter === 'active', fn ($query) => $query->where('is_active', true))
            ->when($statusFilter === 'inactive', fn ($query) => $query->where('is_active', false))
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
            
        return view('admin.clients.index', compact('clients', 'search', 'statusFilter'));
    }

    public function create()
    {
        return view('admin.clients.create');
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
            'client_type' => ['required', 'in:tipe_1,tipe_2'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'client',
            'phone' => $validated['phone'],
            'is_active' => true,
        ]);

        $client = Client::create([
            'user_id' => $user->id,
            'address' => $validated['address'],
            'emergency_contact' => $validated['emergency_contact'] ?? null,
            'client_type' => $validated['client_type'],
            'is_active' => true,
            'created_by' => auth()->id(),
        ]);

        app(NotificationService::class)->notifyAdminsNewClient($client);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client berhasil ditambahkan!');
    }

    public function show(Client $client)
    {
        $client->load(['user', 'students', 'payments', 'createdBy']);
        $gradeLevels = GradeLevel::orderBy('name')->get();

        return view('admin.clients.show', compact('client', 'gradeLevels'));
    }

    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
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
            'client_type' => ['required', 'in:tipe_1,tipe_2'],
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
            'client_type' => $validated['client_type'],
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

        return redirect()->route('admin.clients.index')
            ->with('success', 'Data client berhasil diupdate!');
    }

    public function updateAccount(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($client->user_id)],
            'password' => ['nullable', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
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

        return redirect()->route('admin.clients.show', $client)
            ->with('success', 'Informasi akun client berhasil diupdate.');
    }

    public function updateAddress(Request $request, Client $client)
    {
        $validated = $request->validate([
            'address' => ['required', 'string'],
            'emergency_contact' => ['nullable', 'string', 'max:20'],
        ]);

        $client->update($validated);

        return redirect()->route('admin.clients.show', $client)
            ->with('success', 'Alamat dan kontak darurat berhasil diupdate.');
    }

    public function updateType(Request $request, Client $client)
    {
        $validated = $request->validate([
            'client_type' => ['required', 'in:tipe_1,tipe_2'],
        ]);

        $client->update(['client_type' => $validated['client_type']]);

        $this->recalculatePendingPayments($client);

        return redirect()->route('admin.clients.show', $client)
            ->with('success', 'Tipe client berhasil diupdate.');
    }

    public function destroy(Client $client)
    {
        if ($client->students()->exists() || $client->payments()->exists()) {
            return back()->with('error', 'Client tidak bisa dihapus permanen karena sudah memiliki anak atau histori tagihan. Gunakan Nonaktifkan agar data tetap aman.');
        }

        $user = $client->user;
        $client->delete();
        if ($user) {
            $user->delete();
        }
        
        return redirect()->route('admin.clients.index')
            ->with('success', 'Client dan akun login berhasil dihapus!');
    }

    public function forceDestroy(Request $request, Client $client)
    {
        $validated = $request->validate([
            'confirmation_name' => ['required', 'string'],
        ]);

        if ($validated['confirmation_name'] !== $client->user->name) {
            return back()->with('error', 'Nama konfirmasi tidak sesuai. Penghapusan permanen dibatalkan.');
        }

        $client->loadCount(['students', 'payments']);
        $user = $client->user;
        $clientName = $user?->name ?? "Client #{$client->id}";

        Log::warning('Client force deleted by admin', [
            'admin_id' => auth()->id(),
            'client_id' => $client->id,
            'client_name' => $clientName,
            'students_count' => $client->students_count,
            'payments_count' => $client->payments_count,
        ]);

        $client->delete();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.clients.index')
            ->with('success', "Client {$clientName} dan seluruh data terkait berhasil dihapus permanen.");
    }

    public function deactivate(Client $client)
    {
        $client->update(['is_active' => false]);
        $client->user?->update(['is_active' => false]);

        app(NotificationService::class)->notifyAdminsClientDeactivated($client);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client berhasil dinonaktifkan. Histori siswa, sesi, laporan, dan tagihan tetap tersimpan.');
    }

    public function activate(Client $client)
    {
        $client->update(['is_active' => true]);
        $client->user?->update(['is_active' => true]);

        return redirect()->route('admin.clients.index', ['status' => 'active'])
            ->with('success', 'Client berhasil diaktifkan kembali.');
    }

    private function recalculatePendingPayments(Client $client): void
    {
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
                $payment->update(['amount' => (int) $matches[1] * $pricePerSession]);
            }
        }
    }

    public function storeStudent(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'school_name' => ['nullable', 'string', 'max:255'],
            'grade_level' => ['nullable', 'exists:grade_levels,name'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('students', 'public');
        }

        $validated['client_id'] = $client->id;

        $student = Student::create($validated);

        app(NotificationService::class)->notifyAdminsNewStudent($student);

        return redirect()->route('admin.clients.show', $client)
            ->with('success', "Anak berhasil ditambahkan untuk {$client->user->name}.");
    }
}
