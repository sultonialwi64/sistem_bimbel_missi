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
        $paymentData = []; // [paymentId => [sessionCount, baseAmount, periodKey]]

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

            $paymentData[$payment->id] = [
                'sessionCount' => $sessionCount,
                'baseAmount' => $baseAmount,
                'periodKey' => $periodKey,
            ];
        }

        // 2. Apply discount — full flat per student if that student has >= threshold sessions
        $threshold = config('bimbel.discount.threshold', 8);

        foreach ($payments as $payment) {
            if (! $payment->client || ! $payment->student || ! isset($paymentData[$payment->id])) {
                continue;
            }

            $data = $paymentData[$payment->id];
            $sessionCount = $data['sessionCount'];
            $baseAmount = $data['baseAmount'];

            $discount = 0;
            if ($sessionCount >= $threshold) {
                $discount = $payment->client->discount;
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
        }

        $this->info("Done. {$updated} payments updated.");

        return 0;
    }
}
