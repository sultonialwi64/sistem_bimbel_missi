<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Client;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Salary;
use App\Models\Schedule;
use App\Models\SessionReport;
use App\Models\Student;
use App\Models\StudentProgress;
use App\Models\Subject;
use App\Models\Tutor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting comprehensive seeding...');

        // Create Admin
        $this->command->info('📌 Creating Admin...');
        $admin = User::create([
            'name' => 'Admin Bimbel',
            'email' => 'admin@bimbel.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        // Create Tutors
        $this->command->info('📌 Creating Tutors...');
        $tutors = [];

        $tutor1 = User::create([
            'name' => 'Ahmad Hidayat, S.Si',
            'email' => 'ahmad.tutor@bimbel.com',
            'password' => bcrypt('password'),
            'role' => 'tutor',
            'phone' => '081234567891',
            'is_active' => true,
        ]);

        $tutors[] = Tutor::create([
            'user_id' => $tutor1->id,
            'specialization' => ['Matematika', 'Fisika'],
            'session_rate' => 40000,
            'rating_avg' => 4.8,
            'total_sessions' => 156,
            'status' => 'active',
            'bank_account' => '1234567890',
            'bank_name' => 'BCA',
            'bio' => 'Pengajar berpengalaman 5 tahun, lulusan Matematika ITB. Fokus pada pemahaman konsep dan problem solving.',
            'education' => 'S1 Matematika - ITB',
        ]);

        $tutor2 = User::create([
            'name' => 'Siti Nurhaliza, S.Hum',
            'email' => 'siti.tutor@bimbel.com',
            'password' => bcrypt('password'),
            'role' => 'tutor',
            'phone' => '081234567892',
            'is_active' => true,
        ]);

        $tutors[] = Tutor::create([
            'user_id' => $tutor2->id,
            'specialization' => ['Bahasa Inggris', 'Bahasa Indonesia'],
            'session_rate' => 40000,
            'rating_avg' => 4.9,
            'total_sessions' => 203,
            'status' => 'active',
            'bank_account' => '0987654321',
            'bank_name' => 'Mandiri',
            'bio' => 'Lulusan Sastra Inggris UI, bersertifikat TEFL. Spesialis TOEFL dan IELTS preparation.',
            'education' => 'S1 Sastra Inggris - UI',
        ]);

        $tutor3 = User::create([
            'name' => 'Budi Santoso, S.Si',
            'email' => 'budi.tutor@bimbel.com',
            'password' => bcrypt('password'),
            'role' => 'tutor',
            'phone' => '081234567893',
            'is_active' => true,
        ]);

        $tutors[] = Tutor::create([
            'user_id' => $tutor3->id,
            'specialization' => ['Kimia', 'Biologi'],
            'session_rate' => 40000,
            'rating_avg' => 4.6,
            'total_sessions' => 128,
            'status' => 'active',
            'bank_account' => '5678901234',
            'bank_name' => 'BNI',
            'bio' => 'Pengajar muda yang energik dan sabar. Pendekatan belajar sambil bermain.',
            'education' => 'S1 Kimia - UGM',
        ]);

        // Create Clients
        $this->command->info('📌 Creating Clients...');
        $clients = [];

        $client1 = User::create([
            'name' => 'Rina Wijaya',
            'email' => 'rina.client@bimbel.com',
            'password' => bcrypt('password'),
            'role' => 'client',
            'phone' => '081234567894',
            'is_active' => true,
        ]);

        $clients[] = Client::create([
            'user_id' => $client1->id,
            'address' => 'Jl. Merdeka No. 123, Jakarta Selatan',
            'emergency_contact' => '081234567895',
        ]);

        $client2 = User::create([
            'name' => 'Dedi Kurniawan',
            'email' => 'dedi.client@bimbel.com',
            'password' => bcrypt('password'),
            'role' => 'client',
            'phone' => '081234567896',
            'is_active' => true,
        ]);

        $clients[] = Client::create([
            'user_id' => $client2->id,
            'address' => 'Jl. Sudirman No. 45, Jakarta Pusat',
            'emergency_contact' => '081234567897',
        ]);

        $client3 = User::create([
            'name' => 'Ahmad Subarjo',
            'email' => 'ahmad.client@bimbel.com',
            'password' => bcrypt('password'),
            'role' => 'client',
            'phone' => '081234567898',
            'is_active' => true,
        ]);

        $clients[] = Client::create([
            'user_id' => $client3->id,
            'address' => 'Jl. Gatot Subroto No. 88, Jakarta Selatan',
            'emergency_contact' => '081234567899',
        ]);

        // Create Students
        $this->command->info('📌 Creating Students...');
        $students = [];

        $students[] = Student::create([
            'client_id' => $clients[0]->id,
            'name' => 'Andi Wijaya',
            'birth_date' => '2010-05-15',
            'school_name' => 'SMP Negeri 1 Jakarta',
            'grade_level' => 'SMP',
            'is_active' => true,
        ]);

        $students[] = Student::create([
            'client_id' => $clients[0]->id,
            'name' => 'Dewi Wijaya',
            'birth_date' => '2012-08-20',
            'school_name' => 'SD Negeri 1 Jakarta',
            'grade_level' => 'SD',
            'is_active' => true,
        ]);

        $students[] = Student::create([
            'client_id' => $clients[1]->id,
            'name' => 'Rizky Kurniawan',
            'birth_date' => '2008-03-10',
            'school_name' => 'SMA Negeri 1 Jakarta',
            'grade_level' => 'SMA',
            'is_active' => true,
        ]);

        $students[] = Student::create([
            'client_id' => $clients[2]->id,
            'name' => 'Fitri Handayani',
            'birth_date' => '2011-12-05',
            'school_name' => 'SMP Negeri 5 Jakarta',
            'grade_level' => 'SMP',
            'is_active' => true,
        ]);

        // Create Subjects
        $this->command->info('📌 Creating Subjects...');
        $subjects = [];

        $subjects[] = Subject::create([
            'name' => 'Matematika',
            'description' => 'Matematika untuk SD, SMP, dan SMA',
            'level' => 'SMP',
            'is_active' => true,
        ]);

        $subjects[] = Subject::create([
            'name' => 'Fisika',
            'description' => 'Fisika untuk SMP dan SMA',
            'level' => 'SMA',
            'is_active' => true,
        ]);

        $subjects[] = Subject::create([
            'name' => 'Bahasa Inggris',
            'description' => 'Bahasa Inggris untuk semua level',
            'level' => 'SMP',
            'is_active' => true,
        ]);

        $subjects[] = Subject::create([
            'name' => 'Kimia',
            'description' => 'Kimia untuk SMA',
            'level' => 'SMA',
            'is_active' => true,
        ]);

        $subjects[] = Subject::create([
            'name' => 'Biologi',
            'description' => 'Biologi untuk SMP dan SMA',
            'level' => 'SMA',
            'is_active' => true,
        ]);

        $subjects[] = Subject::create([
            'name' => 'Bahasa Indonesia',
            'description' => 'Bahasa Indonesia untuk semua level',
            'level' => 'SD',
            'is_active' => true,
        ]);

        // Create Schedules (Past and Future)
        $this->command->info('📌 Creating Schedules...');

        // Past schedules (completed)
        for ($i = 1; $i <= 30; $i++) {
            $date = Carbon::now()->subDays(rand(1, 45));
            $student = $students[array_rand($students)];
            $tutor = $tutors[array_rand($tutors)];
            $subject = $subjects[array_rand($subjects)];

            $schedule = Schedule::create([
                'student_id' => $student->id,
                'tutor_id' => $tutor->id,
                'subject_id' => $subject->id,
                'date' => $date,
                'start_time' => '16:00',
                'end_time' => '17:30',
                'status' => 'completed',
                'notes' => 'Sesi pembelajaran regular',
                'created_by' => $admin->id,
            ]);

            // Create Attendance
            Attendance::create([
                'schedule_id' => $schedule->id,
                'tutor_id' => $tutor->id,
                'status' => 'hadir',
                'photo_path' => 'attendances/seed_example.jpg',
                'captured_at' => $date->copy()->setTime(15, 55),
                'verification_status' => 'verified',
                'tutor_lat' => -6.2615,
                'tutor_lng' => 106.8106,
                'tutor_subdistrict' => 'Kebayoran Baru',
            ]);

            // Create Session Report
            SessionReport::create([
                'schedule_id' => $schedule->id,
                'tutor_id' => $tutor->id,
                'student_id' => $student->id,
                'material_covered' => 'Pembahasan materi '.$subject->name.' bab '.rand(1, 10),
                'student_understanding' => rand(3, 5),
                'notes_for_parent' => 'Anak cukup aktif dan antusias dalam belajar',
                'tutor_rating_by_student' => rand(4, 5),
                'parent_rating' => rand(4, 5),
                'parent_feedback' => 'Penjelasan sangat bagus, anak saya senang.',
            ]);
        }

        // Future schedules (upcoming)
        $futureDates = [
            ['date' => Carbon::now()->addDays(1), 'time' => '16:00'],
            ['date' => Carbon::now()->addDays(2), 'time' => '15:00'],
            ['date' => Carbon::now()->addDays(3), 'time' => '16:30'],
            ['date' => Carbon::now()->addDays(5), 'time' => '14:00'],
            ['date' => Carbon::now()->addDays(7), 'time' => '16:00'],
            ['date' => Carbon::now()->addDays(10), 'time' => '15:30'],
            ['date' => Carbon::now()->addDays(14), 'time' => '16:00'],
        ];

        foreach ($futureDates as $future) {
            $student = $students[array_rand($students)];
            $tutor = $tutors[array_rand($tutors)];
            $subject = $subjects[array_rand($subjects)];

            Schedule::create([
                'student_id' => $student->id,
                'tutor_id' => $tutor->id,
                'subject_id' => $subject->id,
                'date' => $future['date'],
                'start_time' => $future['time'],
                'end_time' => Carbon::parse($future['time'])->addMinutes(90)->format('H:i'),
                'status' => 'scheduled',
                'notes' => 'Jadwal sesi pembelajaran',
                'created_by' => $admin->id,
            ]);
        }

        // Create Salaries
        $this->command->info('📌 Creating Salaries...');
        foreach ($tutors as $tutor) {
            // Last month salary (paid)
            $sessionsLastMonth = rand(15, 25);
            $baseSalaryLastMonth = $sessionsLastMonth * $tutor->session_rate;
            Salary::create([
                'tutor_id' => $tutor->id,
                'period_start' => Carbon::now()->subMonth()->startOfMonth(),
                'period_end' => Carbon::now()->subMonth()->endOfMonth(),
                'total_sessions' => $sessionsLastMonth,
                'base_salary' => $baseSalaryLastMonth,
                'bonus' => 0,
                'deduction' => 0,
                'total_amount' => $baseSalaryLastMonth,
                'status' => 'paid',
                'payment_date' => Carbon::now()->subMonth()->addDays(5),
                'approved_by' => $admin->id,
            ]);

            // Current month salary (pending)
            $sessionsCurrentMonth = rand(10, 20);
            $baseSalaryCurrentMonth = $sessionsCurrentMonth * $tutor->session_rate;
            Salary::create([
                'tutor_id' => $tutor->id,
                'period_start' => Carbon::now()->startOfMonth(),
                'period_end' => Carbon::now()->endOfMonth(),
                'total_sessions' => $sessionsCurrentMonth,
                'base_salary' => $baseSalaryCurrentMonth,
                'bonus' => 0,
                'deduction' => 0,
                'total_amount' => $baseSalaryCurrentMonth,
                'status' => 'pending',
            ]);
        }

        // Create Payments
        $this->command->info('📌 Creating Payments...');
        foreach ($clients as $client) {
            $student = $client->students->first();
            if ($student) {
                // Paid payment
                Payment::create([
                    'client_id' => $client->id,
                    'student_id' => $student->id,
                    'amount' => 1200000,
                    'payment_date' => Carbon::now()->subDays(15),
                    'due_date' => Carbon::now()->subDays(10),
                    'status' => 'paid',
                    'payment_method' => 'Bank Transfer',
                    'verified_by' => $admin->id,
                ]);

                // Pending payment
                Payment::create([
                    'client_id' => $client->id,
                    'student_id' => $student->id,
                    'amount' => 1200000,
                    'payment_date' => Carbon::now(),
                    'due_date' => Carbon::now()->addDays(7),
                    'status' => 'pending',
                    'payment_method' => 'Bank Transfer',
                ]);
            }
        }

        // Create Student Progress
        $this->command->info('📌 Creating Student Progress...');
        foreach ($students as $student) {
            $studentSubjects = collect($subjects)->random(rand(1, 2)); // Fix to rand(1, 2) to ensure it works with 6 subjects
            foreach ($studentSubjects as $subject) {
                $tutor = $tutors[array_rand($tutors)];

                StudentProgress::create([
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                    'tutor_id' => $tutor->id,
                    'assessment_date' => Carbon::now()->subDays(rand(5, 30)),
                    'skill_areas' => json_encode([
                        'theory' => rand(60, 95),
                        'practice' => rand(60, 95),
                        'problem_solving' => rand(60, 95),
                    ]),
                    'overall_score' => rand(70, 95),
                    'improvement_notes' => 'Menunjukkan peningkatan yang baik dalam pemahaman konsep',
                    'recommendations' => 'Perlu lebih banyak latihan soal',
                    'level_achieved' => ['beginner', 'intermediate', 'advanced'][rand(0, 2)],
                ]);
            }
        }

        // Create Notifications
        $this->command->info('📌 Creating Notifications...');
        Notification::create([
            'user_id' => $admin->id,
            'type' => 'new_schedule',
            'title' => 'Jadwal Baru Dibuat',
            'message' => 'Ada 7 jadwal baru untuk minggu ini',
            'is_read' => false,
        ]);

        Notification::create([
            'user_id' => $tutors[0]->id,
            'type' => 'salary_ready',
            'title' => 'Gaji Siap Cair',
            'message' => 'Gaji Anda untuk periode ini sudah siap untuk dicairkan',
            'is_read' => false,
        ]);

        Notification::create([
            'user_id' => $clients[0]->id,
            'type' => 'new_report',
            'title' => 'Laporan Sesi Baru',
            'message' => 'Laporan sesi pembelajaran Andi Wijaya sudah tersedia',
            'is_read' => false,
        ]);

        $this->command->info('✅ Seeding completed successfully!');
        $this->command->info('📊 Summary:');
        $this->command->info('   - 1 Admin');
        $this->command->info('   - 3 Tutors');
        $this->command->info('   - 3 Clients');
        $this->command->info('   - 4 Students');
        $this->command->info('   - 6 Subjects');
        $this->command->info('   - 37+ Schedules (past & future)');
        $this->command->info('   - 30+ Session Reports');
        $this->command->info('   - 6 Salaries');
        $this->command->info('   - 6 Payments');
        $this->command->info('   - 4+ Student Progress Records');
        $this->command->info('   - 3 Notifications');
    }
}
