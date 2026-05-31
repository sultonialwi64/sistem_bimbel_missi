<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use App\Models\Schedule;
use App\Models\Tutor;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $periodStart = Carbon::parse($month)->startOfMonth();
        $periodEnd = Carbon::parse($month)->endOfMonth();

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

            $completedSessions = Schedule::where('tutor_id', $tutor->id)
                ->whereBetween('date', [$periodStart->format('Y-m-d'), $periodEnd->format('Y-m-d')])
                ->whereHas('attendance', function ($query) {
                    $query->whereIn('status', ['hadir', 'pindah_lokasi']);
                })
                ->count();

            $baseSalary = $completedSessions * $tutorRatePerSession;
            $totalAmount = $baseSalary;

            if ($salaryRecord) {
                $totalAmount = $baseSalary + $salaryRecord->bonus - $salaryRecord->deduction;
            }

            $tutorSalaries->push((object) [
                'tutor' => $tutor,
                'period_start' => $periodStart,
                'period_end' => $periodEnd,
                'total_sessions' => $completedSessions,
                'base_salary' => $baseSalary,
                'total_amount' => $totalAmount,
                'status' => $salaryRecord ? ($salaryRecord->status === 'pending' ? 'unpaid' : $salaryRecord->status) : 'unpaid',
                'salary_id' => $salaryRecord?->id,
            ]);
        }

        // Sort: total_amount descending (dari terbanyak ke terkecil)
        $tutorSalaries = $tutorSalaries->sortByDesc('total_amount');

        // Hitung total pendapatan perusahaan dari sesi-sesi di bulan ini
        $completedSchedules = Schedule::with('student.client')
            ->whereBetween('date', [$periodStart->format('Y-m-d'), $periodEnd->format('Y-m-d')])
            ->whereHas('attendance', function ($query) {
                $query->whereIn('status', ['hadir', 'pindah_lokasi']);
            })
            ->get();

        $totalCompanyRevenue = $completedSchedules->sum(function ($schedule) {
            return $schedule->student->client->company_margin ?? 10000;
        });

        $companyRatePerSession = null; // Dinamis

        return view('admin.salaries.index', compact('tutorSalaries', 'month', 'totalCompanyRevenue', 'companyRatePerSession'));
    }

    public function show(Salary $salary)
    {
        $salary->load(['tutor.user', 'approvedBy']);

        $schedules = Schedule::with('student.client')
            ->where('tutor_id', $salary->tutor_id)
            ->whereBetween('date', [$salary->period_start, $salary->period_end])
            ->whereHas('attendance', function ($q) {
                $q->whereIn('status', ['hadir', 'pindah_lokasi']);
            })
            ->get();

        $totalClientPaid = $schedules->sum(function ($s) {
            return $s->student->client->session_price ?? 50000;
        });

        $companyEarned = $schedules->sum(function ($s) {
            return $s->student->client->company_margin ?? 10000;
        });

        $clientTypes = $schedules->pluck('student.client.client_type')->unique();
        $clientLabel = $clientTypes->count() === 1
            ? ($clientTypes->first() === 'tipe_1' ? 'Tipe 1 (Rp 45.000)' : 'Tipe 2 (Rp 50.000)')
            : 'Campuran';

        $breakdown = [
            'client_label' => $clientLabel,
            'total_client_paid' => $totalClientPaid,
            'tutor_earned' => $salary->total_sessions * config('bimbel.salary.session_rate_tutor', 40000),
            'company_earned' => $companyEarned,
        ];

        return view('admin.salaries.show', compact('salary', 'breakdown'));
    }

    public function pay(Salary $salary)
    {
        $salary->update([
            'status' => 'paid',
            'payment_date' => now(),
            'payment_proof' => null,
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Gaji berhasil ditandai sudah dibayar!');
    }

    public function payDynamic(Request $request)
    {
        $validated = $request->validate([
            'tutor_id' => ['required', 'exists:tutors,id'],
            'month' => ['required', 'date_format:Y-m'],
        ]);

        $periodStart = Carbon::parse($validated['month'])->startOfMonth();
        $periodEnd = Carbon::parse($validated['month'])->endOfMonth();

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
                'tutor_id' => $validated['tutor_id'],
                'period_start' => $periodStart->format('Y-m-d'),
                'period_end' => $periodEnd->format('Y-m-d'),
            ],
            [
                'total_sessions' => $completedSessions,
                'base_salary' => $baseSalary,
                'bonus' => 0,
                'bonus_reason' => null,
                'deduction' => 0,
                'deduction_reason' => null,
                'total_amount' => $baseSalary,
                'status' => 'paid',
                'payment_date' => now(),
                'approved_by' => auth()->id(),
            ]
        );

        return redirect()->route('admin.salaries.index', ['month' => $validated['month']])
            ->with('success', 'Gaji tutor berhasil dibayar!');
    }
}
