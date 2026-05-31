<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EarningController extends Controller
{
    public function index()
    {
        $tutor = Auth::user()->tutor;

        $tutorRatePerSession = config('bimbel.salary.session_rate_tutor', 40000);

        $periodStart = Carbon::now()->startOfMonth();
        $periodEnd = Carbon::now()->endOfMonth();

        // Cek apakah bulan ini sudah ada record gaji di DB
        $currentMonthSalary = Salary::where('tutor_id', $tutor->id)
            ->whereBetween('period_start', [$periodStart->format('Y-m-d'), $periodEnd->format('Y-m-d')])
            ->first();

        // Ambil semua record gaji dari DB, timpa dengan hitungan fresh
        $salariesFromDb = Salary::where('tutor_id', $tutor->id)
            ->orderByDesc('period_start')
            ->get()
            ->map(function ($salary) use ($tutor) {
                $freshSessions = Schedule::where('tutor_id', $tutor->id)
                    ->whereBetween('date', [$salary->period_start->format('Y-m-d'), $salary->period_end->format('Y-m-d')])
                    ->whereHas('attendance', fn ($q) => $q->whereIn('status', ['hadir', 'pindah_lokasi']))
                    ->count();
                $freshBase = $freshSessions * config('bimbel.salary.session_rate_tutor', 40000);
                $salary->total_sessions = $freshSessions;
                $salary->base_salary = $freshBase;
                $salary->total_amount = $freshBase + $salary->bonus - $salary->deduction;

                return $salary;
            });

        // Jika belum ada record bulan ini, hitung secara dinamis dan tampilkan sebagai virtual row
        $currentMonthVirtual = null;
        if (! $currentMonthSalary) {
            $sessionsThisMonth = Schedule::where('tutor_id', $tutor->id)
                ->whereBetween('date', [$periodStart->format('Y-m-d'), $periodEnd->format('Y-m-d')])
                ->whereHas('attendance', function ($q) {
                    $q->whereIn('status', ['hadir', 'pindah_lokasi']);
                })
                ->count();

            if ($sessionsThisMonth > 0) {
                $baseSalary = $sessionsThisMonth * $tutorRatePerSession;
                $currentMonthVirtual = (object) [
                    'period_start' => $periodStart,
                    'period_end' => $periodEnd,
                    'total_sessions' => $sessionsThisMonth,
                    'base_salary' => $baseSalary,
                    'total_amount' => $baseSalary,
                    'status' => 'unpaid',
                    'payment_date' => null,
                    'is_virtual' => true,
                ];
            }
        }

        $totalEarned = $salariesFromDb->where('status', 'paid')->sum('total_amount');

        $pendingAmount = $salariesFromDb->whereIn('status', ['pending', 'unpaid'])->sum('total_amount');

        // Kalau ada virtual row bulan ini, masukkan ke pending amount display
        if ($currentMonthVirtual) {
            $pendingAmount += $currentMonthVirtual->total_amount;
        }

        return view('tutor.earnings.index', compact(
            'salariesFromDb',
            'currentMonthVirtual',
            'totalEarned',
            'pendingAmount'
        ));
    }
}
