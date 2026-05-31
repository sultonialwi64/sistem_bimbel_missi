<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RecalculatePayments extends Command
{
    protected $signature = 'payments:recalculate';

    protected $description = 'Recalculate all pending payment amounts based on the current client_type prices';

    public function handle()
    {
        $this->info('Fetching all pending payments...');
        $payments = Payment::with(['client', 'student'])->where('status', 'pending')->get();
        $count = 0;

        foreach ($payments as $payment) {
            if (! $payment->client || ! $payment->student) {
                continue;
            }

            $periodEnd = Carbon::parse($payment->due_date)->subDays(7)->endOfDay();
            $periodStart = $periodEnd->copy()->startOfMonth();

            $sessionCount = Schedule::where('student_id', $payment->student_id)
                ->whereBetween('date', [$periodStart, $periodEnd])
                ->whereHas('attendance', function ($query) {
                    $query->whereIn('status', ['hadir', 'pindah_lokasi']);
                })
                ->count();

            $pricePerSession = $payment->client->session_price;

            if ($sessionCount > 0) {
                $correctAmount = $sessionCount * $pricePerSession;
                if ($payment->amount != $correctAmount) {
                    $this->warn("Updating Payment ID {$payment->id} ({$payment->student->name}) | Old: {$payment->amount} -> New: {$correctAmount}");
                    $payment->amount = $correctAmount;
                    $payment->save();
                    $count++;
                }
            } else {
                preg_match('/\((\d+)\s*sesi\)/i', $payment->notes, $matches);
                if (isset($matches[1])) {
                    $noteSessionCount = (int) $matches[1];
                    $correctAmountByNote = $noteSessionCount * $pricePerSession;
                    if ($payment->amount != $correctAmountByNote) {
                        $this->warn("Updating Payment ID {$payment->id} ({$payment->student->name}) via Notes | Old: {$payment->amount} -> New: {$correctAmountByNote}");
                        $payment->amount = $correctAmountByNote;
                        $payment->save();
                        $count++;
                    }
                }
            }
        }

        $this->info("Recalculation complete. {$count} payments updated.");
    }
}
