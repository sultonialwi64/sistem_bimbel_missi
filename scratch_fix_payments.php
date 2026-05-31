<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$payments = \App\Models\Payment::with(['client', 'student'])->where('status', 'pending')->get();
echo "Found " . $payments->count() . " pending payments.\n";
$count = 0;

foreach ($payments as $payment) {
    if ($payment->client) {
        $pricePerSession = $payment->client->session_price; // Assuming this accessor exists and depends on client_type
        
        // Extract session count from notes if possible, or recalculate
        // The notes format is: "Auto-generated for Mei 2026 (8 sesi)"
        preg_match('/\((\d+)\ssesi\)/', $payment->notes, $matches);
        
        $sessionCount = 0;
        if (isset($matches[1])) {
            $sessionCount = (int)$matches[1];
        } else {
            // Try different regex just in case
            preg_match('/\((\d+)\s*sesi\)/i', $payment->notes, $matches);
            if (isset($matches[1])) {
                $sessionCount = (int)$matches[1];
            }
        }
        
        echo "Check Payment ID {$payment->id}: Amount: {$payment->amount}, Client Type: {$payment->client->client_type}, Price/Sesi: {$pricePerSession}, Sesi: {$sessionCount}\n";
        
        if ($sessionCount > 0) {
            $correctAmount = $sessionCount * $pricePerSession;
            if ($payment->amount != $correctAmount) {
                echo "Updating Payment ID: {$payment->id} for {$payment->student->name} | Old Amount: {$payment->amount} | New Amount: {$correctAmount} ({$sessionCount} sessions @ {$pricePerSession})\n";
                $payment->amount = $correctAmount;
                $payment->save();
                $count++;
            }
        }
    }
}

echo "Done updating {$count} payments.\n";
