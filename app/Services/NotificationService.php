<?php

namespace App\Services;

use App\Models\{User, Notification};
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    /**
     * Send in-app notification
     */
    public function sendToUser(
        User $user,
        string $type,
        string $title,
        string $message,
        array $data = [],
        ?string $actionUrl = null
    ): Notification {
        $notification = Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'action_url' => $actionUrl,
            'is_read' => false,
        ]);

        // Send email notification if enabled
        if (config('bimbel.notification.email_enabled', true)) {
            $this->sendEmail($user, $title, $message, $actionUrl);
        }

        return $notification;
    }

    /**
     * Send notification to multiple users
     */
    public function broadcast(
        array $users,
        string $type,
        string $title,
        string $message,
        array $data = [],
        ?string $actionUrl = null
    ): void {
        foreach ($users as $user) {
            $this->sendToUser($user, $type, $title, $message, $data, $actionUrl);
        }
    }

    private function admins()
    {
        return User::where('role', 'admin')->where('is_active', true)->get();
    }

    public function notifyAdminsNewSchedule($schedule, int $createdCount = 1): void
    {
        $schedule->loadMissing(['student.client.user', 'tutor.user']);

        $title = $createdCount > 1 ? 'Jadwal Baru Dibuat' : 'Jadwal Baru';
        $startTime = \Carbon\Carbon::parse($schedule->start_time)->format('H:i');
        $message = $createdCount > 1
            ? "{$createdCount} jadwal baru dibuat untuk {$schedule->student->name} dengan tutor {$schedule->tutor->user->name}."
            : "Jadwal baru untuk {$schedule->student->name} dengan tutor {$schedule->tutor->user->name} pada {$schedule->date->format('d M Y')} pukul {$startTime}.";

        $this->broadcast(
            $this->admins()->all(),
            'new_schedule',
            $title,
            $message,
            ['schedule_id' => $schedule->id, 'created_count' => $createdCount],
            $createdCount > 1 ? route('admin.schedules.index') : route('admin.schedules.show', $schedule)
        );
    }

    public function notifyAdminsNewReport($report): void
    {
        $report->loadMissing(['student.client.user', 'tutor.user', 'schedule']);

        Notification::where('type', 'missing_report')
            ->where('data->schedule_id', $report->schedule_id)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        $this->broadcast(
            $this->admins()->all(),
            'new_report',
            'Laporan Sesi Baru',
            "{$report->tutor->user->name} submit laporan sesi untuk {$report->student->name}.",
            ['report_id' => $report->id, 'schedule_id' => $report->schedule_id],
            route('admin.session-reports.show', $report)
        );
    }

    public function notifyAdminsNewClient($client): void
    {
        $client->loadMissing('user');

        $this->broadcast(
            $this->admins()->all(),
            'new_client',
            'Client Baru Dibuat',
            "{$client->user->name} baru ditambahkan sebagai client.",
            ['client_id' => $client->id],
            route('admin.clients.show', $client)
        );
    }

    public function notifyAdminsNewStudent($student): void
    {
        $student->loadMissing('client.user');

        $this->broadcast(
            $this->admins()->all(),
            'new_student',
            'Siswa Baru Dibuat',
            "{$student->name} ditambahkan untuk client {$student->client->user->name}.",
            ['student_id' => $student->id, 'client_id' => $student->client_id],
            route('admin.students.show', $student)
        );
    }

    public function notifyAdminsMissingReport($schedule): void
    {
        $schedule->loadMissing(['student.client.user', 'tutor.user']);

        foreach ($this->admins() as $admin) {
            $exists = Notification::where('user_id', $admin->id)
                ->where('type', 'missing_report')
                ->where('data->schedule_id', $schedule->id)
                ->exists();

            if (! $exists) {
                Notification::create([
                    'user_id' => $admin->id,
                    'type' => 'missing_report',
                    'title' => 'Sesi Belum Ada Laporan',
                    'message' => "Sesi {$schedule->student->name} dengan tutor {$schedule->tutor->user->name} sudah selesai, tapi laporan belum diisi.",
                    'data' => ['schedule_id' => $schedule->id, 'student_id' => $schedule->student_id, 'tutor_id' => $schedule->tutor_id],
                    'action_url' => route('admin.schedules.show', $schedule),
                    'is_read' => false,
                ]);
            }
        }
    }

    public function notifyAdminsClientDeactivated($client): void
    {
        $client->loadMissing('user');

        $this->broadcast(
            $this->admins()->all(),
            'data_deactivated',
            'Client Dinonaktifkan',
            "{$client->user->name} dinonaktifkan. Histori data lama tetap tersimpan.",
            ['client_id' => $client->id, 'data_type' => 'client'],
            route('admin.clients.show', $client)
        );
    }

    public function notifyAdminsStudentDeactivated($student): void
    {
        $student->loadMissing('client.user');

        $this->broadcast(
            $this->admins()->all(),
            'data_deactivated',
            'Siswa Dinonaktifkan',
            "{$student->name} dari client {$student->client->user->name} dinonaktifkan.",
            ['student_id' => $student->id, 'client_id' => $student->client_id, 'data_type' => 'student'],
            route('admin.students.show', $student)
        );
    }

    /**
     * Send email notification
     */
    private function sendEmail(User $user, string $title, string $message, ?string $actionUrl = null): void
    {
        // TODO: Implement email sending with Laravel Mail
        // For now, just log the notification
        \Log::info("Email notification to {$user->email}: {$title} - {$message}");
    }

    /**
     * Notify admin about new tutor registration
     */
    public function notifyNewTutor(User $tutor): void
    {
        $admins = User::where('role', 'admin')->get();
        
        $this->broadcast(
            $admins->all(),
            'new_tutor',
            'New Tutor Registered',
            "{$tutor->name} has been registered as a new tutor.",
            ['tutor_id' => $tutor->tutor->id],
            route('admin.tutors.show', $tutor->tutor)
        );
    }

    /**
     * Notify client about new schedule
     */
    public function notifyNewSchedule(User $client, User $student, User $tutor, $schedule): void
    {
        $this->sendToUser(
            $client,
            'new_schedule',
            'New Schedule Created',
            "New schedule for {$student->name} with tutor {$tutor->name}.",
            ['schedule_id' => $schedule->id],
            route('client.schedules.index')
        );
    }

    /**
     * Notify tutor about upcoming schedule
     */
    public function notifyUpcomingSchedule(User $tutor, $schedule): void
    {
        $this->sendToUser(
            $tutor,
            'upcoming_schedule',
            'Upcoming Schedule Reminder',
            "You have a schedule with {$schedule->student->name} tomorrow at {$schedule->start_time}.",
            ['schedule_id' => $schedule->id],
            route('tutor.schedules.show', $schedule)
        );
    }

    /**
     * Notify client about new session report
     */
    public function notifyNewReport(User $client, User $student, User $tutor, $report): void
    {
        $this->sendToUser(
            $client,
            'new_report',
            'New Session Report Available',
            "New session report from {$tutor->name} for {$student->name}.",
            ['report_id' => $report->id],
            route('client.reports.show', $report)
        );
    }

    /**
     * Notify client about payment due
     */
    public function notifyPaymentDue(User $client, $payment): void
    {
        $this->sendToUser(
            $client,
            'payment_due',
            'Payment Due Soon',
            "Payment of Rp " . number_format($payment->amount, 0, ',', '.') . " is due on {$payment->due_date->format('d M Y')}.",
            ['payment_id' => $payment->id],
            route('client.payments.index')
        );
    }

    /**
     * Notify tutor about salary ready
     */
    public function notifySalaryReady(User $tutor, $salary): void
    {
        $this->sendToUser(
            $tutor,
            'salary_ready',
            'Salary Ready',
            "Your salary of Rp " . number_format($salary->total_amount, 0, ',', '.') . " is ready for payment.",
            ['salary_id' => $salary->id],
            route('tutor.earnings.index')
        );
    }

    /**
     * Notify admin about low-rated tutor
     */
    public function notifyLowTutorRating(User $admin, User $tutor, float $rating): void
    {
        $this->sendToUser(
            $admin,
            'quality_alert',
            'Quality Alert: Low Rating',
            "Tutor {$tutor->name}'s rating has dropped to {$rating}.",
            ['tutor_id' => $tutor->tutor->id, 'rating' => $rating],
            route('admin.tutors.show', $tutor->tutor)
        );
    }

    /**
     * Get unread notification count for user
     */
    public function getUnreadCount(User $user): int
    {
        return Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Get recent notifications for user
     */
    public function getRecentNotifications(User $user, int $limit = 10): \Illuminate\Support\Collection
    {
        return Notification::where('user_id', $user->id)
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Mark all notifications as read for user
     */
    public function markAllAsRead(User $user): void
    {
        Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);
    }
}
