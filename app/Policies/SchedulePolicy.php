<?php

namespace App\Policies;

use App\Models\Schedule;
use App\Models\User;

class SchedulePolicy
{
    /**
     * Determine if the tutor can view the schedule.
     */
    public function view(User $user, Schedule $schedule): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isTutor()) {
            return $user->tutor && $user->tutor->id === $schedule->tutor_id;
        }

        if ($user->isClient()) {
            return $user->client && $user->client->id === $schedule->student->client_id;
        }

        return false;
    }
}
