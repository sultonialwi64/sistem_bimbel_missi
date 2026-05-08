<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Tutor, Client, Student, Schedule, Payment, Salary, SessionReport};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth());
        $endDate = $request->input('end_date', now()->endOfMonth());

        // Revenue report
        $revenue = Payment::where('status', 'paid')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->sum('amount');

        // Expense report (salaries)
        $expenses = Salary::where('status', 'paid')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->sum('total_amount');

        // Session report
        $totalSessions = Schedule::whereBetween('date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->count();

        // New students
        $newStudents = Student::whereBetween('created_at', [$startDate, $endDate])->count();

        // Top performing tutors
        $topTutors = DB::table('session_reports')
            ->join('tutors', 'session_reports.tutor_id', '=', 'tutors.id')
            ->join('users', 'tutors.user_id', '=', 'users.id')
            ->whereBetween('session_reports.created_at', [$startDate, $endDate])
            ->select('tutors.id', 'users.name', DB::raw('AVG(session_reports.student_understanding) as avg_understanding'), DB::raw('COUNT(*) as total_sessions'))
            ->groupBy('tutors.id', 'users.name')
            ->orderBy('avg_understanding', 'desc')
            ->limit(5)
            ->get();

        // Monthly trend (last 6 months)
        $monthlyTrend = Payment::where('status', 'paid')
            ->select(
                DB::raw('DATE_FORMAT(payment_date, "%Y-%m") as month'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get()
            ->reverse()
            ->values();

        return view('admin.reports.index', compact(
            'revenue',
            'expenses',
            'totalSessions',
            'newStudents',
            'topTutors',
            'monthlyTrend',
            'startDate',
            'endDate'
        ));
    }
}
