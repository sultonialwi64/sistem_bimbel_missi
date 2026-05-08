<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $tutor = Auth::user()->tutor;
        
        // Get students that the tutor has taught or will teach
        $studentIds = $tutor->schedules()->pluck('student_id');
        
        $students = Student::whereIn('id', $studentIds)
            ->with(['client.user'])
            ->latest()
            ->paginate(15);
        
        return view('tutor.students.index', compact('students'));
    }
}
