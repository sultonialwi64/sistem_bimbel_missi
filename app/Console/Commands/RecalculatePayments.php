<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use App\Models\Schedule;
use Carbon\Carbon;

class RecalculatePayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:recalculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate all pending payment amounts based on the current client_type prices';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Fetching all pending payments...");
        $payments = Payment::with(['client', 'student'])->where('status', 'pending')->get();
        $count = 0;

        foreach ($payments as $payment) {
            if (!$payment->client || !$payment->student) continue;

            // Recalculate sessions based on period
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
                // Try from notes if schedule returns 0
                preg_match('/\((\d+)\s*sesi\)/i', $payment->notes, $matches);
                if (isset($matches[1])) {
                    $noteSessionCount = (int)$matches[1];
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
