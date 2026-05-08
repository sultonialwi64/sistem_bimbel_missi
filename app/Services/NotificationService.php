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
        string $actionUrl = null
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
        string $actionUrl = null
    ): void {
        foreach ($users as $user) {
            $this->sendToUser($user, $type, $title, $message, $data, $actionUrl);
        }
    }

    /**
     * Send email notification
     */
    private function sendEmail(User $user, string $title, string $message, string $actionUrl = null): void
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
