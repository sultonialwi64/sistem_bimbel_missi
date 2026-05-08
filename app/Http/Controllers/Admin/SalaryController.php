<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Salary, Tutor, Schedule};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    /**
     * Struktur Bagi Hasil Per Sesi:
     *  - Harga ke Client   : Rp 50.000
     *  - Bagian Tutor      : Rp 40.000  ← yang masuk ke gaji tutor
     *  - Bagian Perusahaan : Rp 10.000  ← margin perusahaan
     */

    public function index()
    {
        $salaries = Salary::with(['tutor.user', 'approvedBy'])
            ->latest()
            ->paginate(15);

        // Daftar tutor aktif untuk form generate
        $tutors = Tutor::with('user')->where('status', 'active')->get();

        // Hitung total pendapatan perusahaan dari semua salary yang ada
        $companyRatePerSession = config('bimbel.salary.session_rate_company', 10000);
        $totalCompanyRevenue = Salary::sum(
            \DB::raw('total_sessions * ' . $companyRatePerSession)
        );

        return view('admin.salaries.index', compact('salaries', 'tutors', 'totalCompanyRevenue', 'companyRatePerSession'));
    }

    public function show(Salary $salary)
    {
        $salary->load(['tutor.user', 'approvedBy']);

        // Hitung breakdown untuk salary ini
        $tutorRate    = config('bimbel.salary.session_rate_tutor', 40000);
        $companyRate  = config('bimbel.salary.session_rate_company', 10000);
        $clientPrice  = config('bimbel.salary.session_price_client', 50000);

        $breakdown = [
            'client_price'      => $clientPrice,
            'tutor_rate'        => $tutorRate,
            'company_rate'      => $companyRate,
            'total_client_paid' => $salary->total_sessions * $clientPrice,
            'tutor_earned'      => $salary->total_sessions * $tutorRate,
            'company_earned'    => $salary->total_sessions * $companyRate,
        ];

        return view('admin.salaries.show', compact('salary', 'breakdown'));
    }

    public function pay(Salary $salary)
    {
        $salary->update([
            'status'       => 'paid',
            'payment_date' => now(),
            'payment_proof' => null,
            'approved_by'  => auth()->id(),
        ]);

        return redirect()->route('admin.salaries.index')
            ->with('success', 'Gaji berhasil ditandai sudah dibayar!');
    }

    public function generate()
    {
        $validated = request()->validate([
            'tutor_id'     => ['required', 'exists:tutors,id'],
            'period_start' => ['required', 'date'],
            'period_end'   => ['required', 'date', 'after:period_start'],
        ]);

        // Cegah generate ganda untuk tutor & period yang sama
        $duplicate = Salary::where('tutor_id', $validated['tutor_id'])
            ->where('period_start', $validated['period_start'])
            ->where('period_end', $validated['period_end'])
            ->exists();

        if ($duplicate) {
            return back()
                ->withErrors(['period_start' => 'Gaji untuk tutor ini pada periode tersebut sudah pernah digenerate.'])
                ->withInput();
        }

        // Rate tutor dari config (Rp 40.000/sesi)
        $tutorRatePerSession = config('bimbel.salary.session_rate_tutor', 40000);

        // Hitung sesi berdasarkan kehadiran (Hanya hitung yang status 'hadir' atau 'pindah_lokasi')
        $completedSessions = Schedule::where('tutor_id', $validated['tutor_id'])
            ->whereBetween('date', [$validated['period_start'], $validated['period_end']])
            ->whereHas('attendance', function ($query) {
                $query->whereIn('status', ['hadir', 'pindah_lokasi']);
            })
            ->count();

        // Rumus sederhana: Total = Sesi Selesai × Rate Tutor
        $baseSalary  = $completedSessions * $tutorRatePerSession;

        $salary = Salary::create([
            'tutor_id'         => $validated['tutor_id'],
            'period_start'     => $validated['period_start'],
            'period_end'       => $validated['period_end'],
            'total_sessions'   => $completedSessions,
            'rate_per_session' => $tutorRatePerSession,
            'base_salary'      => $baseSalary,
            'bonus'            => 0,
            'bonus_reason'     => null,
            'deduction'        => 0,
            'deduction_reason' => null,
            'total_amount'     => $baseSalary,
            'status'           => 'pending',
        ]);

        return redirect()->route('admin.salaries.show', $salary)
            ->with('success',
                "✅ Gaji berhasil digenerate! " .
                "{$completedSessions} sesi × Rp " . number_format($tutorRatePerSession, 0, ',', '.') .
                " = Rp " . number_format($baseSalary, 0, ',', '.')
            );
    }
}
