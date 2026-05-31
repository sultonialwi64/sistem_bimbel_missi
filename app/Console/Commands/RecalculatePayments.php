<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RecalculatePayments extends Command
{
    protected $signature = 'payments:recalculate {--all : Recalculate also paid/cancelled payments}';

    protected $description = 'Recalculate pending payment amounts & discounts based on current pricing';

    public function handle()
    {
        $statuses = $this->option('all') ? ['pending', 'paid', 'overdue', 'cancelled'] : ['pending'];

        $this->info('Fetching payments...');
        $payments = Payment::with(['client', 'student'])
            ->whereIn('status', $statuses)
            ->get();

        if ($payments->isEmpty()) {
            $this->info('No payments found.');

            return 0;
        }

        // 1. First pass: recalculate session count, base amount, and collect client totals
        $updated = 0;
        $clientPeriodSessions = [];

        foreach ($payments as $payment) {
            if (! $payment->client || ! $payment->student) {
                continue;
            }

            $periodEnd = Carbon::parse($payment->due_date)->subDays(7)->endOfDay();
            $periodStart = $periodEnd->copy()->startOfMonth();
            $periodKey = $periodStart->format('Y-m');

            $sessionCount = Schedule::where('student_id', $payment->student_id)
                ->whereBetween('date', [$periodStart, $periodEnd])
                ->whereHas('attendance', fn ($q) => $q->whereIn('status', ['hadir', 'pindah_lokasi']))
                ->count();

            // Fallback to notes
            if ($sessionCount === 0) {
                preg_match('/\((\d+)\s*sesi\)/i', $payment->notes, $matches);
                $sessionCount = isset($matches[1]) ? (int) $matches[1] : 0;
            }

            $pricePerSession = $payment->client->session_price;
            $baseAmount = $sessionCount * $pricePerSession;

            // Track per-client session totals for this period
            $cid = $payment->client_id;
            $clientPeriodSessions[$periodKey][$cid] = ($clientPeriodSessions[$periodKey][$cid] ?? 0) + $sessionCount;

            // Temp store for second pass
            $payment->_sessionCount = $sessionCount;
            $payment->_baseAmount = $baseAmount;
            $payment->_periodKey = $periodKey;
        }

        // 2. Second pass: apply discount
        $threshold = config('bimbel.discount.threshold', 8);

        foreach ($payments as $payment) {
            if (! $payment->client || ! $payment->student) {
                continue;
            }

            $sessionCount = $payment->_sessionCount;
            $baseAmount = $payment->_baseAmount;
            $periodKey = $payment->_periodKey;

            // Calculate proportional discount
            $clientTotalSessions = $clientPeriodSessions[$periodKey][$payment->client_id] ?? 0;
            $discount = 0;
            if ($clientTotalSessions >= $threshold) {
                $share = $clientTotalSessions > 0 ? $sessionCount / $clientTotalSessions : 0;
                $discount = (int) round($payment->client->discount * $share);
            }

            $newAmount = $baseAmount - $discount;

            if ($payment->amount != $newAmount || $payment->discount != $discount) {
                $this->warn(sprintf(
                    'Updating Payment #%d (%s) | Amount: %s -> %s | Discount: %s -> %s',
                    $payment->id,
                    $payment->student->name,
                    number_format($payment->amount, 0, ',', '.'),
                    number_format($newAmount, 0, ',', '.'),
                    number_format($payment->discount ?? 0, 0, ',', '.'),
                    number_format($discount, 0, ',', '.')
                ));
                $payment->amount = $newAmount;
                $payment->discount = $discount;
                $payment->save();
                $updated++;
            }

            // Cleanup temp props
            unset($payment->_sessionCount, $payment->_baseAmount, $payment->_periodKey);
        }

        $this->info("Done. {$updated} payments updated.");

        return 0;
    }
}
