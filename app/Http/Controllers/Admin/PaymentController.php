<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tentukan bulan yang mau dilihat (Default: Bulan lalu, karena tagihan dibuat setelah bulan berakhir)
        $defaultMonth = \Carbon\Carbon::now()->subMonth()->format('Y-m');
        $monthFilter = $request->input('filter_month', $defaultMonth);
        $date = \Carbon\Carbon::parse($monthFilter);
        $periodStart = $date->copy()->startOfMonth();
        $periodEnd = $date->copy()->endOfMonth();

        // 2. AUTO-GENERATE TAGIHAN (Tanpa perlu klik tombol)
        $students = \App\Models\Student::with('client')->get();

        foreach ($students as $student) {
            $exists = Payment::where('student_id', $student->id)
                ->where('due_date', '>=', $periodStart)
                ->where('due_date', '<=', $periodEnd->copy()->addDays(7))
                ->exists();

            if (!$exists) {
                // Hitung absen hadir/pindah lokasi
                $sessionCount = \App\Models\Schedule::where('student_id', $student->id)
                    ->whereBetween('date', [$periodStart, $periodEnd])
                    ->whereHas('attendance', function ($query) {
                        $query->whereIn('status', ['hadir', 'pindah_lokasi']);
                    })
                    ->count();

                // Kalau ada sesi, buatkan tagihannya diam-diam
                if ($sessionCount > 0) {
                    $clientPricePerSession = $student->client->session_price;
                    Payment::create([
                        'client_id' => $student->client_id,
                        'student_id' => $student->id,
                        'amount' => $sessionCount * $clientPricePerSession,
                        'payment_date' => null, // Dikosongkan karena statusnya masih pending
                        'due_date' => $periodEnd->copy()->addDays(7), // Jatuh tempo 7 hari setelah akhir bulan
                        'status' => 'pending',
                        'notes' => "Auto-generated for " . $date->translatedFormat('F Y') . " ($sessionCount sesi)",
                    ]);
                }
            }
        }

        // 3. TAMPILKAN LISTNYA
        $query = Payment::with(['client.user', 'student', 'verifiedBy'])->orderBy('amount', 'desc')->latest();

        if ($request->filled('filter_month')) {
            // Due date = akhir bulan periode + 7 hari
            // Jadi untuk filter periode Mei, due_date ada di antara 8 Mei s/d 7 Juni
            $query->whereBetween('due_date', [
                $periodStart->copy()->addDays(7),  // 1 Mei + 7 = 8 Mei (batas bawah, exclude tagihan April yg due_date 7 Mei)
                $periodEnd->copy()->addDays(7),    // 31 Mei + 7 = 7 Juni (due_date tagihan Mei)
            ]);
        }

        // Filter Status
        $statusFilter = $request->input('status', 'all');
        if ($statusFilter === 'unpaid') {
            $query->whereIn('status', ['pending', 'overdue']);
        } elseif ($statusFilter === 'paid') {
            $query->where('status', 'paid');
        }

        $payments = $query->paginate(15)->withQueryString();
        
        return view('admin.payments.index', compact('payments', 'statusFilter'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['client.user', 'student', 'verifiedBy']);
        return view('admin.payments.show', compact('payment'));
    }

    public function verify(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:paid,overdue,cancelled'],
        ]);

        $payment->update([
            'status'       => $validated['status'],
            'verified_by'  => auth()->id(),
            'payment_date' => $validated['status'] === 'paid' ? now() : $payment->payment_date,
        ]);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Pembayaran berhasil diverifikasi!');
    }

}
