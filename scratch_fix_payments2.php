<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$clients = \App\Models\Client::with('user')->get();
foreach ($clients as $c) {
    if (str_contains(strtolower($c->user->name), 'zendria')) {
        echo "Found client: {$c->user->name} | ID: {$c->id} | Type: {$c->client_type}\n";
        $c->client_type = 'tipe_1';
        $c->save();
        echo "Updated to tipe_1.\n";
    }
}

$payments = \App\Models\Payment::with(['client', 'student'])->where('status', 'pending')->get();
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
        
    $pricePerSession = $payment->client->session_price; // Assuming this accessor exists
    
    if ($sessionCount > 0) {
        $correctAmount = $sessionCount * $pricePerSession;
        if ($payment->amount != $correctAmount) {
            echo "Updating Payment ID {$payment->id} for {$payment->student->name}\n";
            echo "  Old Amount: {$payment->amount}\n";
            echo "  New Amount: {$correctAmount} ({$sessionCount} sessions @ {$pricePerSession})\n";
            
            $payment->amount = $correctAmount;
            $payment->save();
            $count++;
        }
    }
}
echo "Done updating {$count} payments.\n";
