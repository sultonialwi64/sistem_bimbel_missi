<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$payments = \App\Models\Payment::with(['client.user'])->where('status', 'pending')->get();
$count = 0;
foreach ($payments as $payment) {
    if (!$payment->client) continue;
    
    // We only care about tipe_1 clients whose price should be 45,000
    if ($payment->client->client_type === 'tipe_1') {
        // If the amount is divisible by 50,000, it means it was generated using the old 50,000 price.
        if ($payment->amount > 0 && $payment->amount % 50000 == 0) {
            $sessionCount = $payment->amount / 50000;
            $correctAmount = $sessionCount * 45000;
            
            echo "Updating Payment ID {$payment->id} for {$payment->client->user->name} (Tipe 1)\n";
            echo "  Old Amount: {$payment->amount} ({$sessionCount} sessions @ 50k)\n";
            echo "  New Amount: {$correctAmount} ({$sessionCount} sessions @ 45k)\n";
            
            $payment->amount = $correctAmount;
            $payment->save();
            $count++;
        } elseif ($payment->amount % 45000 == 0) {
            echo "Payment ID {$payment->id} for {$payment->client->user->name} is already correct (Amount: {$payment->amount}).\n";
        } else {
            echo "Payment ID {$payment->id} for {$payment->client->user->name} has unusual amount: {$payment->amount}\n";
        }
    }
}
echo "Done updating {$count} payments.\n";
