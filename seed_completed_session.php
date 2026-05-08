<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Client;
use App\Models\Tutor;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\User;

$clients = Client::with(['students', 'user'])->get();
$tutor = Tutor::first();
$subject = Subject::first();
$admin = User::where('role', 'admin')->first() ?? User::first();

if (!$tutor || !$subject) {
    echo "Tutor or Subject not found. Please ensure database has basic data.\n";
    exit;
}

$count = 0;
foreach ($clients as $client) {
    $student = $client->students->first();
    if ($student) {
        $schedule = Schedule::create([
            'student_id' => $student->id,
            'tutor_id' => $tutor->id,
            'subject_id' => $subject->id,
            'date' => now()->subDays(1),
            'start_time' => '14:00:00',
            'end_time' => '15:30:00',
            'status' => 'completed',
            'notes' => 'Dummy session for rating test',
            'created_by' => $admin->id
        ]);
        echo 'Seeded completed session for student: ' . $student->name . ' (Client Email: ' . $client->user->email . ")\n";
        $count++;
    }
}

echo "Done! Seeded $count completed sessions.\n";
