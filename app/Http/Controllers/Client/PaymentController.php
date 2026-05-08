<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $client = Auth::user()->client;
        $studentIds = $client->students()->pluck('id');
        
        $payments = Payment::whereIn('student_id', $studentIds)
            ->with(['student', 'verifiedBy'])
            ->latest()
            ->paginate(15);
        
        $totalPending = Payment::whereIn('student_id', $studentIds)
            ->whereIn('status', ['pending', 'overdue'])
            ->sum('amount');
        
        $totalPaid = Payment::whereIn('student_id', $studentIds)
            ->where('status', 'paid')
            ->sum('amount');
        
        return view('client.payments.index', compact('payments', 'totalPending', 'totalPaid'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', 'string'],
            'payment_proof' => ['required', 'image', 'max:2048'],
            'notes' => ['nullable', 'string'],
        ]);

        // Authorize - check if student belongs to client
        $student = $validated['student_id'];
        if (Auth::user()->client->students()->where('id', $student)->count() === 0) {
            abort(403);
        }

        $path = $request->file('payment_proof')->store('payment-proofs', 'public');

        Payment::create([
            'client_id' => Auth::user()->client->id,
            'student_id' => $validated['student_id'],
            'amount' => $validated['amount'],
            'payment_date' => now(),
            'due_date' => now()->addDays(7),
            'status' => 'pending',
            'payment_method' => $validated['payment_method'],
            'payment_proof' => $path,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('client.payments.index')
            ->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.');
    }
}
