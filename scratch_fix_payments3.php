<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$payments = \App\Models\Payment::with(['client.user', 'student'])->where('status', 'pending')->get();
$count = 0;
foreach ($payments as $payment) {
    if (!$payment->client) continue;
    
    // Determine period from due date
    $periodEnd = \Carbon\Carbon::parse($payment->due_date)->subDays(7)->endOfDay();
    $periodStart = $periodEnd->copy()->startOfMonth();
    
    $sessionCount = \App\Models\Schedule::where('student_id', $payment->student_id)
        ->whereBetween('date', [$periodStart, $periodEnd])
        ->whereHas('attendance', function ($query) {
            $query->whereIn('status', ['hadir', 'pindah_lokasi']);
        })
        ->count();
        
    $pricePerSession = $payment->client->session_price;
    $correctAmount = $sessionCount * $pricePerSession;
    
    if ($payment->amount != $correctAmount && $sessionCount > 0) {
        echo "Updating {$payment->client->user->name} ({$payment->client->client_type}) | Old: {$payment->amount} | New: {$correctAmount}\n";
        $payment->amount = $correctAmount;
        $payment->save();
        $count++;
    } elseif ($sessionCount == 0 && $payment->amount > 0) {
        // Just checking why sessionCount is 0 for some
        echo "WARNING: {$payment->client->user->name} has amount {$payment->amount} but 0 sessions found in period.\n";
        
        // Let's recalculate based on notes instead!
        preg_match('/\((\d+)\s*sesi\)/i', $payment->notes, $matches);
        if (isset($matches[1])) {
            $noteSessionCount = (int)$matches[1];
            $correctAmountByNote = $noteSessionCount * $pricePerSession;
            if ($payment->amount != $correctAmountByNote) {
                echo "-> By Notes ($noteSessionCount sesi), should be $correctAmountByNote. Updating!\n";
                $payment->amount = $correctAmountByNote;
                $payment->save();
                $count++;
            }
        }
    }
}
echo "Done updating {$count} payments.\n";
