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

    public function index(Request $request)
    {
        $month = $request->get('month', date('Y-m'));
        $periodStart = \Carbon\Carbon::parse($month)->startOfMonth();
        $periodEnd = \Carbon\Carbon::parse($month)->endOfMonth();

        // Daftar tutor aktif
        $tutors = Tutor::with('user')->where('status', 'active')->get();

        $tutorRatePerSession = config('bimbel.salary.session_rate_tutor', 40000);

        // Ambil salary yang sudah ada di bulan ini
        $existingSalaries = Salary::whereBetween('period_start', [$periodStart->format('Y-m-d'), $periodEnd->format('Y-m-d')])
            ->get()
            ->keyBy('tutor_id');

        $tutorSalaries = collect();

        foreach ($tutors as $tutor) {
            $salaryRecord = $existingSalaries->get($tutor->id);
            
            if ($salaryRecord) {
                $tutorSalaries->push((object)[
                    'tutor' => $tutor,
                    'period_start' => $periodStart,
                    'period_end' => $periodEnd,
                    'total_sessions' => $salaryRecord->total_sessions,
                    'base_salary' => $salaryRecord->base_salary,
                    'total_amount' => $salaryRecord->total_amount,
                    'status' => $salaryRecord->status === 'pending' ? 'unpaid' : $salaryRecord->status,
                    'salary_id' => $salaryRecord->id,
                ]);
            } else {
                $completedSessions = Schedule::where('tutor_id', $tutor->id)
                    ->whereBetween('date', [$periodStart->format('Y-m-d'), $periodEnd->format('Y-m-d')])
                    ->whereHas('attendance', function ($query) {
                        $query->whereIn('status', ['hadir', 'pindah_lokasi']);
                    })
                    ->count();

                $baseSalary = $completedSessions * $tutorRatePerSession;
                
                $tutorSalaries->push((object)[
                    'tutor' => $tutor,
                    'period_start' => $periodStart,
                    'period_end' => $periodEnd,
                    'total_sessions' => $completedSessions,
                    'base_salary' => $baseSalary,
                    'total_amount' => $baseSalary,
                    'status' => 'unpaid',
                    'salary_id' => null,
                ]);
            }
        }

        // Sort: total_amount descending (dari terbanyak ke terkecil)
        $tutorSalaries = $tutorSalaries->sortByDesc('total_amount');

        // Hitung total pendapatan perusahaan dari semua salary yang ada
        $companyRatePerSession = config('bimbel.salary.session_rate_company', 10000);
        $totalCompanyRevenue = Salary::sum(
            \DB::raw('total_sessions * ' . $companyRatePerSession)
        );

        return view('admin.salaries.index', compact('tutorSalaries', 'month', 'totalCompanyRevenue', 'companyRatePerSession'));
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

        return redirect()->back()->with('success', 'Gaji berhasil ditandai sudah dibayar!');
    }

    public function payDynamic(Request $request)
    {
        $validated = $request->validate([
            'tutor_id' => ['required', 'exists:tutors,id'],
            'month'    => ['required', 'date_format:Y-m'],
        ]);

        $periodStart = \Carbon\Carbon::parse($validated['month'])->startOfMonth();
        $periodEnd   = \Carbon\Carbon::parse($validated['month'])->endOfMonth();

        $completedSessions = Schedule::where('tutor_id', $validated['tutor_id'])
            ->whereBetween('date', [$periodStart->format('Y-m-d'), $periodEnd->format('Y-m-d')])
            ->whereHas('attendance', function ($query) {
                $query->whereIn('status', ['hadir', 'pindah_lokasi']);
            })
            ->count();

        $tutorRatePerSession = config('bimbel.salary.session_rate_tutor', 40000);
        $baseSalary = $completedSessions * $tutorRatePerSession;

        $salary = Salary::updateOrCreate(
            [
                'tutor_id'     => $validated['tutor_id'],
                'period_start' => $periodStart->format('Y-m-d'),
                'period_end'   => $periodEnd->format('Y-m-d'),
            ],
            [
                'total_sessions'   => $completedSessions,
                'rate_per_session' => $tutorRatePerSession,
                'base_salary'      => $baseSalary,
                'bonus'            => 0,
                'bonus_reason'     => null,
                'deduction'        => 0,
                'deduction_reason' => null,
                'total_amount'     => $baseSalary,
                'status'           => 'paid',
                'payment_date'     => now(),
                'approved_by'      => auth()->id(),
            ]
        );

        return redirect()->route('admin.salaries.index', ['month' => $validated['month']])
            ->with('success', 'Gaji tutor berhasil dibayar!');
    }
}
