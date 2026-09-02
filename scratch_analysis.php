<?php

use App\Models\Schedule;
use App\Models\Payment;
use App\Models\Salary;
use Carbon\Carbon;

$financialDate = Carbon::parse('2026-08-01');
$financialStart = $financialDate->copy()->startOfMonth();
$financialEnd = $financialDate->copy()->endOfMonth();

// 1. Dashboard Logic
$validSessionsThisMonth = Schedule::with('student.client')
    ->whereBetween('date', [$financialStart->format('Y-m-d'), $financialEnd->format('Y-m-d')])
    ->where('status', 'completed')
    ->whereHas('attendance', function ($q) {
        $q->whereIn('status', ['hadir', 'pindah_lokasi']);
    })->get();

$dashboardNetIncome = $validSessionsThisMonth->sum(function ($schedule) {
    return $schedule->student->client->company_margin ?? 10000;
});
echo "Dashboard Net Income: " . $dashboardNetIncome . "\n";

// 2. Client Payments logic for August sessions
// Assuming payments for August sessions are billed early September or end of August
$invoiceDueStart = $financialStart->copy()->addDays(7);
$invoiceDueEnd = $financialEnd->copy()->addDays(7);

// Total Discounts given for payments with due date between $invoiceDueStart and $invoiceDueEnd
$totalDiscounts = Payment::whereBetween('due_date', [$invoiceDueStart->format('Y-m-d'), $invoiceDueEnd->format('Y-m-d')])
    ->sum('discount');
echo "Total Discounts given in Invoices: " . $totalDiscounts . "\n";

// 3. Tutor Salary adjustments (Bonus/Deductions)
// Salaries for August period
$totalBonus = Salary::whereBetween('period_start', [$financialStart->format('Y-m-d'), $financialEnd->format('Y-m-d')])
    ->sum('bonus');
$totalDeductions = Salary::whereBetween('period_start', [$financialStart->format('Y-m-d'), $financialEnd->format('Y-m-d')])
    ->sum('deduction');

echo "Total Tutor Bonuses: " . $totalBonus . "\n";
echo "Total Tutor Deductions: " . $totalDeductions . "\n";

// 4. Real Net Income
// Real Net Income = Dashboard Base Net Income - Discounts - Bonuses + Deductions
$realNetIncome = $dashboardNetIncome - $totalDiscounts - $totalBonus + $totalDeductions;
echo "Calculated Real Net Income: " . $realNetIncome . "\n";
echo "Difference from dashboard: " . ($dashboardNetIncome - $realNetIncome) . "\n";

