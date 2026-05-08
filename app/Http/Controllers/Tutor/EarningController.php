<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EarningController extends Controller
{
    public function index()
    {
        $tutor = Auth::user()->tutor;
        
        $salaries = Salary::where('tutor_id', $tutor->id)
            ->latest()
            ->paginate(15);
        
        $totalEarned = Salary::where('tutor_id', $tutor->id)
            ->where('status', 'paid')
            ->sum('total_amount');
        
        $pendingAmount = Salary::where('tutor_id', $tutor->id)
            ->where('status', 'pending')
            ->sum('total_amount');
        
        return view('tutor.earnings.index', compact('salaries', 'totalEarned', 'pendingAmount'));
    }
}
