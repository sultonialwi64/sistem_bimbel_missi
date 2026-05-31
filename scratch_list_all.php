<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$clients = \App\Models\Client::with('user')->get();
foreach ($clients as $client) {
    echo "Client: {$client->user->name} | Tipe: {$client->client_type}\n";
}

$payments = \App\Models\Payment::with(['client.user'])->where('status', 'pending')->get();
foreach ($payments as $p) {
    echo "Payment ID: {$p->id} | Name: {$p->client->user->name} | Amount: {$p->amount}\n";
}
