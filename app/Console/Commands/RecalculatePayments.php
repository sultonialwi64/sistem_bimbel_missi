<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RecalculatePayments extends Command
{
    protected $signature = 'payments:recalculate';

    protected $description = 'Recalculate pending payment amounts & discounts based on current pricing';

    public function handle()
    {
        $this->info('Fetching payments...');
        $payments = Payment::with(['client', 'student'])
            ->where('status', 'pending')
            ->get();

        $updated = 0;

        foreach ($payments as $payment) {
            if (! $payment->client || ! $payment->student) {
                continue;
            }

            $periodEnd = Carbon::parse($payment->due_date)->subDays(7)->endOfDay();
            $periodStart = $periodEnd->copy()->startOfMonth();

            $sessionCount = Schedule::where('student_id', $payment->student_id)
                ->whereBetween('date', [$periodStart, $periodEnd])
                ->whereHas('attendance', fn ($q) => $q->whereIn('status', ['hadir', 'pindah_lokasi']))
                ->count();

            if ($sessionCount === 0) {
                preg_match('/\((\d+)\s*sesi\)/i', $payment->notes, $matches);
                $sessionCount = isset($matches[1]) ? (int) $matches[1] : 0;
            }

            $pricePerSession = $payment->client->session_price;
            $baseAmount = $sessionCount * $pricePerSession;

            $discount = 0;
            if ($sessionCount >= config('bimbel.discount.threshold', 8)) {
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
    }
}
