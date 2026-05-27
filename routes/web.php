<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Tutor\DashboardController as TutorDashboardController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('welcome');
});

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
            return app(AdminDashboardController::class)->index();
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
        Route::get('/tutors', [App\Http\Controllers\Admin\TutorController::class, 'index'])->name('tutors.index');
        Route::get('/tutors/create', [App\Http\Controllers\Admin\TutorController::class, 'create'])->name('tutors.create');
        Route::post('/tutors', [App\Http\Controllers\Admin\TutorController::class, 'store'])->name('tutors.store');
        Route::get('/tutors/{tutor}', [App\Http\Controllers\Admin\TutorController::class, 'show'])->name('tutors.show');
        Route::get('/tutors/{tutor}/edit', [App\Http\Controllers\Admin\TutorController::class, 'edit'])->name('tutors.edit');
        Route::put('/tutors/{tutor}', [App\Http\Controllers\Admin\TutorController::class, 'update'])->name('tutors.update');
        Route::delete('/tutors/{tutor}', [App\Http\Controllers\Admin\TutorController::class, 'destroy'])->name('tutors.destroy');
        
        // Clients management
        Route::get('/clients', [App\Http\Controllers\Admin\ClientController::class, 'index'])->name('clients.index');
        Route::get('/clients/create', [App\Http\Controllers\Admin\ClientController::class, 'create'])->name('clients.create');
        Route::post('/clients', [App\Http\Controllers\Admin\ClientController::class, 'store'])->name('clients.store');
        Route::get('/clients/{client}', [App\Http\Controllers\Admin\ClientController::class, 'show'])->name('clients.show');
        Route::get('/clients/{client}/edit', [App\Http\Controllers\Admin\ClientController::class, 'edit'])->name('clients.edit');
        Route::put('/clients/{client}', [App\Http\Controllers\Admin\ClientController::class, 'update'])->name('clients.update');
        Route::delete('/clients/{client}', [App\Http\Controllers\Admin\ClientController::class, 'destroy'])->name('clients.destroy');
        
        // Students management
        Route::get('/students', [App\Http\Controllers\Admin\StudentController::class, 'index'])->name('students.index');
        Route::get('/students/create', [App\Http\Controllers\Admin\StudentController::class, 'create'])->name('students.create');
        Route::post('/students', [App\Http\Controllers\Admin\StudentController::class, 'store'])->name('students.store');
        Route::get('/students/{student}', [App\Http\Controllers\Admin\StudentController::class, 'show'])->name('students.show');
        Route::get('/students/{student}/edit', [App\Http\Controllers\Admin\StudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{student}', [App\Http\Controllers\Admin\StudentController::class, 'update'])->name('students.update');
        Route::delete('/students/{student}', [App\Http\Controllers\Admin\StudentController::class, 'destroy'])->name('students.destroy');
        
        // Subjects management
        Route::get('/subjects', [App\Http\Controllers\Admin\SubjectController::class, 'index'])->name('subjects.index');
        Route::get('/subjects/create', [App\Http\Controllers\Admin\SubjectController::class, 'create'])->name('subjects.create');
        Route::post('/subjects', [App\Http\Controllers\Admin\SubjectController::class, 'store'])->name('subjects.store');
        Route::get('/subjects/{subject}', [App\Http\Controllers\Admin\SubjectController::class, 'show'])->name('subjects.show');
        Route::get('/subjects/{subject}/edit', [App\Http\Controllers\Admin\SubjectController::class, 'edit'])->name('subjects.edit');
        Route::put('/subjects/{subject}', [App\Http\Controllers\Admin\SubjectController::class, 'update'])->name('subjects.update');
        Route::delete('/subjects/{subject}', [App\Http\Controllers\Admin\SubjectController::class, 'destroy'])->name('subjects.destroy');
        
        // Grade Levels management
        Route::resource('grade-levels', App\Http\Controllers\Admin\GradeLevelController::class);
        
        // Schedules management
        Route::get('/schedules', [App\Http\Controllers\Admin\ScheduleController::class, 'index'])->name('schedules.index');
        Route::get('/schedules/create', [App\Http\Controllers\Admin\ScheduleController::class, 'create'])->name('schedules.create');
        Route::post('/schedules', [App\Http\Controllers\Admin\ScheduleController::class, 'store'])->name('schedules.store');
        Route::get('/schedules/{schedule}', [App\Http\Controllers\Admin\ScheduleController::class, 'show'])->name('schedules.show');
        Route::get('/schedules/{schedule}/edit', [App\Http\Controllers\Admin\ScheduleController::class, 'edit'])->name('schedules.edit');
        Route::put('/schedules/{schedule}', [App\Http\Controllers\Admin\ScheduleController::class, 'update'])->name('schedules.update');
        Route::delete('/schedules/{schedule}', [App\Http\Controllers\Admin\ScheduleController::class, 'destroy'])->name('schedules.destroy');
        
        // Salaries management
        Route::get('/salaries', [App\Http\Controllers\Admin\SalaryController::class, 'index'])->name('salaries.index');
        Route::get('/salaries/{salary}', [App\Http\Controllers\Admin\SalaryController::class, 'show'])->name('salaries.show');
        Route::post('/salaries/{salary}/pay', [App\Http\Controllers\Admin\SalaryController::class, 'pay'])->name('salaries.pay');
        Route::post('/salaries/pay-dynamic', [App\Http\Controllers\Admin\SalaryController::class, 'payDynamic'])->name('salaries.pay-dynamic');
        
        // Payments management
        Route::get('/payments', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}', [App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('payments.show');
        Route::post('/payments/{payment}/verify', [App\Http\Controllers\Admin\PaymentController::class, 'verify'])->name('payments.verify');
        
        // Reports
        Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');

        // Session Reports
        Route::get('/session-reports', [App\Http\Controllers\Admin\SessionReportController::class, 'index'])->name('session-reports.index');
        Route::get('/session-reports/{sessionReport}', [App\Http\Controllers\Admin\SessionReportController::class, 'show'])->name('session-reports.show');

        // Student Progress
        Route::get('/student-progress', [App\Http\Controllers\Admin\StudentProgressController::class, 'index'])->name('student-progress.index');
        Route::get('/student-progress/{student}', [App\Http\Controllers\Admin\StudentProgressController::class, 'show'])->name('student-progress.show');
        Route::get('/student-progress/{student}/pdf', [App\Http\Controllers\Admin\StudentProgressController::class, 'exportPdf'])->name('student-progress.pdf');
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
        Route::post('/attendance/submit/{schedule}', [App\Http\Controllers\Tutor\AttendanceController::class, 'submitAttendance'])->name('attendance.submit');
        Route::post('/attendance/update-photo/{schedule}', [App\Http\Controllers\Tutor\AttendanceController::class, 'updatePhoto'])->name('attendance.update-photo');
        
        // Session Reports
        Route::get('/reports', [App\Http\Controllers\Tutor\ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/create/{schedule}', [App\Http\Controllers\Tutor\ReportController::class, 'create'])->name('reports.create');
        Route::post('/reports', [App\Http\Controllers\Tutor\ReportController::class, 'store'])->name('reports.store');
        Route::get('/reports/{report}', [App\Http\Controllers\Tutor\ReportController::class, 'show'])->name('reports.show');
        
        // Profile & Earnings
        Route::get('/earnings', [App\Http\Controllers\Tutor\EarningController::class, 'index'])->name('earnings.index');
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
        Route::get('/children', [App\Http\Controllers\Client\ChildController::class, 'index'])->name('children.index');
        Route::get('/children/{student}', [App\Http\Controllers\Client\ChildController::class, 'show'])->name('children.show');
        
        // Schedules
        Route::get('/schedules', [App\Http\Controllers\Client\ScheduleController::class, 'index'])->name('schedules.index');
        
        // Progress Reports
        Route::get('/progress', [App\Http\Controllers\Client\ProgressController::class, 'index'])->name('progress.index');
        Route::get('/progress/{student}', [App\Http\Controllers\Client\ProgressController::class, 'show'])->name('progress.show');
        
        // Session Reports
        Route::get('/reports', [App\Http\Controllers\Client\ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{report}', [App\Http\Controllers\Client\ReportController::class, 'show'])->name('reports.show');
        Route::post('/reports/{report}/feedback', [App\Http\Controllers\Client\ReportController::class, 'submitFeedback'])->name('reports.feedback');
        
        // Payments
        Route::get('/payments', [App\Http\Controllers\Client\PaymentController::class, 'index'])->name('payments.index');
        Route::post('/payments', [App\Http\Controllers\Client\PaymentController::class, 'store'])->name('payments.store');
        
        // Assessments
        Route::post('/assessments', [App\Http\Controllers\Client\AssessmentController::class, 'store'])->name('assessments.store');
    });
});

// Secure Public Route for downloading PDF report (No login required)
Route::get('/public/report/download/{student}', [App\Http\Controllers\Admin\StudentProgressController::class, 'exportPdf'])
    ->name('public.report.download')
    ->middleware('signed');

require __DIR__.'/auth.php';
