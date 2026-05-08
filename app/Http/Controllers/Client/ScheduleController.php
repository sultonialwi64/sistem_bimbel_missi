<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $client = Auth::user()->client;
        $studentIds = $client->students()->pluck('id');
        
        $schedules = Schedule::whereIn('student_id', $studentIds)
            ->with(['tutor.user', 'student', 'subject'])
            ->where('date', '>=', today())
            ->orderBy('date')
            ->paginate(15);
        
        return view('client.schedules.index', compact('schedules'));
    }
}
