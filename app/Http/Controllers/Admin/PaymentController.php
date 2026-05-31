<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tentukan bulan yang mau dilihat (Default: Bulan lalu, karena tagihan dibuat setelah bulan berakhir)
        $defaultMonth = Carbon::now()->subMonth()->format('Y-m');
        $monthFilter = $request->input('filter_month', $defaultMonth);
        $date = Carbon::parse($monthFilter);
        $periodStart = $date->copy()->startOfMonth();
        $periodEnd = $date->copy()->endOfMonth();

        // 2. TAMPILKAN LISTNYA
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

        // Detect clients with multiple students (for display hint in discount column)
        $multiStudentClientIds = $payments->getCollection()
            ->groupBy('client_id')
            ->filter(fn ($group) => $group->count() > 1)
            ->keys()
            ->toArray();

        return view('admin.payments.index', compact('payments', 'statusFilter', 'multiStudentClientIds'));
    }

    public function generate(Request $request)
    {
        $monthFilter = $request->input('filter_month', Carbon::now()->subMonth()->format('Y-m'));
        $date = Carbon::parse($monthFilter);
        $periodStart = $date->copy()->startOfMonth();
        $periodEnd = $date->copy()->endOfMonth();

        $students = Student::with('client')->get();
        $generated = 0;

        // Count sessions per student
        $studentData = [];

        foreach ($students as $student) {
            $sessionCount = Schedule::where('student_id', $student->id)
                ->whereBetween('date', [$periodStart, $periodEnd])
                ->whereHas('attendance', function ($query) {
                    $query->whereIn('status', ['hadir', 'pindah_lokasi']);
                })
                ->count();

            if ($sessionCount > 0) {
                $studentData[] = [
                    'student' => $student,
                    'sessionCount' => $sessionCount,
                ];
            }
        }

        // Create payments — full flat discount per student if that student has >= threshold sessions
        foreach ($studentData as $data) {
            $student = $data['student'];
            $sessionCount = $data['sessionCount'];

            $exists = Payment::where('student_id', $student->id)
                ->where('due_date', '>=', $periodStart)
                ->where('due_date', '<=', $periodEnd->copy()->addDays(7))
                ->exists();

            if ($exists) {
                continue;
            }

            $client = $student->client;
            $baseAmount = $sessionCount * $client->session_price;

            $discount = 0;
            $discountNote = '';
            if ($sessionCount >= config('bimbel.discount.threshold', 8)) {
                $discount = $client->discount;
                $discountNote = ' · diskon Rp '.number_format($discount, 0, ',', '.');
            }

            Payment::create([
                'client_id' => $client->id,
                'student_id' => $student->id,
                'amount' => $baseAmount - $discount,
                'discount' => $discount,
                'payment_date' => null,
                'due_date' => $periodEnd->copy()->addDays(7),
                'status' => 'pending',
                'notes' => 'Auto-generated for '.$date->translatedFormat('F Y')." ($sessionCount sesi$discountNote)",
            ]);
            $generated++;
        }

        return redirect()->route('admin.payments.index', ['filter_month' => $monthFilter])
            ->with('success', "$generated tagihan berhasil digenerate untuk ".$date->translatedFormat('F Y'));
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
            'status' => $validated['status'],
            'verified_by' => auth()->id(),
            'payment_date' => $validated['status'] === 'paid' ? now() : $payment->payment_date,
        ]);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Pembayaran berhasil diverifikasi!');
    }
}
