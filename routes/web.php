<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GradeLevelController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SalaryController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\SessionReportController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StudentProgressController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TutorController;
use App\Http\Controllers\Client\AssessmentController;
use App\Http\Controllers\Client\ChildController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\ProgressController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Tutor\AttendanceController;
use App\Http\Controllers\Tutor\DashboardController as TutorDashboardController;
use App\Http\Controllers\Tutor\EarningController;
use App\Models\Schedule;
use App\Models\Tutor;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $sessionCount = Schedule::where('status', 'completed')
        ->whereHas('attendance', function ($query) {
            $query->whereIn('status', ['hadir', 'pindah_lokasi']);
        })
        ->count();

    $landingTutors = Tutor::query()
        ->select('tutors.*')
        ->join('users', 'users.id', '=', 'tutors.user_id')
        ->where('status', 'active')
        ->orderByRaw("CASE WHEN users.avatar IS NULL OR users.avatar = '' THEN 1 ELSE 0 END")
        ->latest()
        ->with('user')
        ->take(4)
        ->get();

    $landingStats = [
        [
            'value' => '100+',
            'target' => 100,
            'suffix' => '+',
            'label' => 'Siswa pernah belajar bersama Missi',
            'accent' => 'text-miss-navy',
        ],
        [
            'value' => number_format($sessionCount),
            'target' => $sessionCount,
            'suffix' => '',
            'label' => 'Sesi belajar telah terlaksana',
            'accent' => 'text-miss-goldDark',
        ],
    ];

    return view('welcome', compact('landingTutors', 'landingStats'));
});

Route::get('/tutors', function () {
    $tutors = Tutor::query()
        ->select('tutors.*')
        ->join('users', 'users.id', '=', 'tutors.user_id')
        ->where('status', 'active')
        ->orderByRaw("CASE WHEN users.avatar IS NULL OR users.avatar = '' THEN 1 ELSE 0 END")
        ->latest()
        ->with('user')
        ->get();

    return view('tutors.index', compact('tutors'));
})->name('tutors.public.index');

Route::middleware('auth')->group(function () {
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Role-based dashboard routing
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return app(AdminDashboardController::class)->index(request());
        } elseif ($user->isTutor()) {
            return app(TutorDashboardController::class)->index();
        } elseif ($user->isClient()) {
            return app(ClientDashboardController::class)->index();
        }

        return redirect()->route('login');
    })->name('dashboard');

    // Admin routes
    Route::prefix('admin')->middleware('role:admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Tutors management
        Route::get('/tutors', [TutorController::class, 'index'])->name('tutors.index');
        Route::get('/tutors/create', [TutorController::class, 'create'])->name('tutors.create');
        Route::post('/tutors', [TutorController::class, 'store'])->name('tutors.store');
        Route::get('/tutors/{tutor}', [TutorController::class, 'show'])->name('tutors.show');
        Route::get('/tutors/{tutor}/edit', [TutorController::class, 'edit'])->name('tutors.edit');
        Route::put('/tutors/{tutor}', [TutorController::class, 'update'])->name('tutors.update');
        Route::delete('/tutors/{tutor}', [TutorController::class, 'destroy'])->name('tutors.destroy');

        // Clients management
        Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
        Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
        Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
        Route::post('/clients/{client}/deactivate', [ClientController::class, 'deactivate'])->name('clients.deactivate');
        Route::post('/clients/{client}/activate', [ClientController::class, 'activate'])->name('clients.activate');
        Route::delete('/clients/{client}/force-destroy', [ClientController::class, 'forceDestroy'])->name('clients.force-destroy');
        Route::patch('/clients/{client}/account', [ClientController::class, 'updateAccount'])->name('clients.update-account');
        Route::patch('/clients/{client}/address', [ClientController::class, 'updateAddress'])->name('clients.update-address');
        Route::patch('/clients/{client}/type', [ClientController::class, 'updateType'])->name('clients.update-type');
        Route::post('/clients/{client}/students', [ClientController::class, 'storeStudent'])->name('clients.students.store');
        Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show');
        Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
        Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
        Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');

        // Students management
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/students', [StudentController::class, 'store'])->name('students.store');
        Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
        Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
        Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

        // Subjects management
        Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
        Route::get('/subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
        Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
        Route::get('/subjects/{subject}', [SubjectController::class, 'show'])->name('subjects.show');
        Route::get('/subjects/{subject}/edit', [SubjectController::class, 'edit'])->name('subjects.edit');
        Route::put('/subjects/{subject}', [SubjectController::class, 'update'])->name('subjects.update');
        Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy');

        // Grade Levels management
        Route::resource('grade-levels', GradeLevelController::class);

        // Schedules management
        Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
        Route::get('/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
        Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
        Route::get('/schedules/{schedule}', [ScheduleController::class, 'show'])->name('schedules.show');
        Route::get('/schedules/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
        Route::put('/schedules/{schedule}', [ScheduleController::class, 'update'])->name('schedules.update');
        Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');

        // Salaries management
        Route::get('/salaries', [SalaryController::class, 'index'])->name('salaries.index');
        Route::get('/salaries/{salary}', [SalaryController::class, 'show'])->name('salaries.show');
        Route::post('/salaries/{salary}/pay', [SalaryController::class, 'pay'])->name('salaries.pay');
        Route::post('/salaries/pay-dynamic', [SalaryController::class, 'payDynamic'])->name('salaries.pay-dynamic');

        // Payments management
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::post('/payments/generate', [PaymentController::class, 'generate'])->name('payments.generate');
        Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::post('/payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
        Route::post('/payments/{payment}/mark-wa-sent', [PaymentController::class, 'markWaSent'])->name('payments.mark-wa-sent');

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

        // Session Reports
        Route::get('/session-reports', [SessionReportController::class, 'index'])->name('session-reports.index');
        Route::get('/session-reports/{sessionReport}', [SessionReportController::class, 'show'])->name('session-reports.show');

        // Student Progress
        Route::get('/student-progress', [StudentProgressController::class, 'index'])->name('student-progress.index');
        Route::get('/student-progress/{student}', [StudentProgressController::class, 'show'])->name('student-progress.show');
        Route::get('/student-progress/{student}/pdf', [StudentProgressController::class, 'exportPdf'])->name('student-progress.pdf');
    });

    // Tutor routes
    Route::prefix('tutor')->middleware('role:tutor')->name('tutor.')->group(function () {
        Route::get('/dashboard', [TutorDashboardController::class, 'index'])->name('dashboard');

        // Schedules
        Route::get('/schedules', [App\Http\Controllers\Tutor\ScheduleController::class, 'index'])->name('schedules.index');
        Route::get('/schedules/create', [App\Http\Controllers\Tutor\ScheduleController::class, 'create'])->name('schedules.create');
        Route::post('/schedules', [App\Http\Controllers\Tutor\ScheduleController::class, 'store'])->name('schedules.store');
        Route::get('/schedules/{schedule}', [App\Http\Controllers\Tutor\ScheduleController::class, 'show'])->name('schedules.show');
        Route::get('/schedules/{schedule}/edit', [App\Http\Controllers\Tutor\ScheduleController::class, 'edit'])->name('schedules.edit');
        Route::put('/schedules/{schedule}', [App\Http\Controllers\Tutor\ScheduleController::class, 'update'])->name('schedules.update');
        Route::delete('/schedules/{schedule}', [App\Http\Controllers\Tutor\ScheduleController::class, 'destroy'])->name('schedules.destroy');

        // Attendance (Photo & Status)
        Route::post('/attendance/submit/{schedule}', [AttendanceController::class, 'submitAttendance'])->name('attendance.submit');
        Route::post('/attendance/update-photo/{schedule}', [AttendanceController::class, 'updatePhoto'])->name('attendance.update-photo');

        // Session Reports
        Route::get('/reports', [App\Http\Controllers\Tutor\ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/create/{schedule}', [App\Http\Controllers\Tutor\ReportController::class, 'create'])->name('reports.create');
        Route::post('/reports', [App\Http\Controllers\Tutor\ReportController::class, 'store'])->name('reports.store');
        Route::get('/reports/{report}', [App\Http\Controllers\Tutor\ReportController::class, 'show'])->name('reports.show');

        // Profile & Earnings
        Route::get('/earnings', [EarningController::class, 'index'])->name('earnings.index');
        // Clients management
        Route::get('/clients', [App\Http\Controllers\Tutor\ClientController::class, 'index'])->name('clients.index');
        Route::get('/clients/create', [App\Http\Controllers\Tutor\ClientController::class, 'create'])->name('clients.create');
        Route::post('/clients', [App\Http\Controllers\Tutor\ClientController::class, 'store'])->name('clients.store');
        Route::get('/clients/{client}', [App\Http\Controllers\Tutor\ClientController::class, 'show'])->name('clients.show');
        Route::get('/clients/{client}/edit', [App\Http\Controllers\Tutor\ClientController::class, 'edit'])->name('clients.edit');
        Route::put('/clients/{client}', [App\Http\Controllers\Tutor\ClientController::class, 'update'])->name('clients.update');
        Route::delete('/clients/{client}', [App\Http\Controllers\Tutor\ClientController::class, 'destroy'])->name('clients.destroy');

        // Students management
        Route::get('/students', [App\Http\Controllers\Tutor\StudentController::class, 'index'])->name('students.index');
        Route::get('/students/create', [App\Http\Controllers\Tutor\StudentController::class, 'create'])->name('students.create');
        Route::post('/students', [App\Http\Controllers\Tutor\StudentController::class, 'store'])->name('students.store');
        Route::get('/students/{student}', [App\Http\Controllers\Tutor\StudentController::class, 'show'])->name('students.show');
        Route::get('/students/{student}/edit', [App\Http\Controllers\Tutor\StudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{student}', [App\Http\Controllers\Tutor\StudentController::class, 'update'])->name('students.update');
        Route::delete('/students/{student}', [App\Http\Controllers\Tutor\StudentController::class, 'destroy'])->name('students.destroy');
    });

    // Client routes
    Route::prefix('client')->middleware('role:client')->name('client.')->group(function () {
        Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');

        // Children (Students)
        Route::get('/children', [ChildController::class, 'index'])->name('children.index');
        Route::get('/children/{student}', [ChildController::class, 'show'])->name('children.show');

        // Schedules
        Route::get('/schedules', [App\Http\Controllers\Client\ScheduleController::class, 'index'])->name('schedules.index');

        // Progress Reports
        Route::get('/progress', [ProgressController::class, 'index'])->name('progress.index');
        Route::get('/progress/{student}', [ProgressController::class, 'show'])->name('progress.show');

        // Session Reports
        Route::get('/reports', [App\Http\Controllers\Client\ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{report}', [App\Http\Controllers\Client\ReportController::class, 'show'])->name('reports.show');
        Route::post('/reports/{report}/feedback', [App\Http\Controllers\Client\ReportController::class, 'submitFeedback'])->name('reports.feedback');

        // Payments
        Route::get('/payments', [App\Http\Controllers\Client\PaymentController::class, 'index'])->name('payments.index');
        Route::post('/payments', [App\Http\Controllers\Client\PaymentController::class, 'store'])->name('payments.store');

        // Assessments
        Route::post('/assessments', [AssessmentController::class, 'store'])->name('assessments.store');
    });
});

// Secure public routes for report access (no login required, signed URL required).
Route::get('/public/report/{student}', [StudentProgressController::class, 'publicReport'])
    ->name('public.report.show')
    ->middleware('signed');

Route::get('/public/report/download/{student}', [StudentProgressController::class, 'exportPdf'])
    ->name('public.report.download')
    ->middleware('signed');

require __DIR__.'/auth.php';
