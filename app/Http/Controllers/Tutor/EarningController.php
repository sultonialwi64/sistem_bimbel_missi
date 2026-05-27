<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\{Salary, Schedule};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EarningController extends Controller
{
    public function index()
    {
        $tutor = Auth::user()->tutor;

        $tutorRatePerSession = config('bimbel.salary.session_rate_tutor', 40000);

        $periodStart = Carbon::now()->startOfMonth();
        $periodEnd   = Carbon::now()->endOfMonth();

        // Cek apakah bulan ini sudah ada record gaji di DB
        $currentMonthSalary = Salary::where('tutor_id', $tutor->id)
            ->whereBetween('period_start', [$periodStart->format('Y-m-d'), $periodEnd->format('Y-m-d')])
            ->first();

        // Ambil semua record gaji dari DB (sudah ada)
        $salariesFromDb = Salary::where('tutor_id', $tutor->id)
            ->orderByDesc('period_start')
            ->get();

        // Jika belum ada record bulan ini, hitung secara dinamis dan tampilkan sebagai virtual row
        $currentMonthVirtual = null;
        if (!$currentMonthSalary) {
            $sessionsThisMonth = Schedule::where('tutor_id', $tutor->id)
                ->whereBetween('date', [$periodStart->format('Y-m-d'), $periodEnd->format('Y-m-d')])
                ->whereHas('attendance', function ($q) {
                    $q->whereIn('status', ['hadir', 'pindah_lokasi']);
                })
                ->count();

            if ($sessionsThisMonth > 0) {
                $baseSalary = $sessionsThisMonth * $tutorRatePerSession;
                $currentMonthVirtual = (object) [
                    'period_start'     => $periodStart,
                    'period_end'       => $periodEnd,
                    'total_sessions'   => $sessionsThisMonth,
                    'rate_per_session' => $tutorRatePerSession,
                    'base_salary'      => $baseSalary,
                    'total_amount'     => $baseSalary,
                    'status'           => 'unpaid',
                    'payment_date'     => null,
                    'is_virtual'       => true,
                ];
            }
        }

        $totalEarned = Salary::where('tutor_id', $tutor->id)
            ->where('status', 'paid')
            ->sum('total_amount');

        $pendingAmount = Salary::where('tutor_id', $tutor->id)
            ->whereIn('status', ['pending', 'unpaid'])
            ->sum('total_amount');

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
