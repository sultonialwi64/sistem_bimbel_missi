@php
    $role = auth()->user()->role;
    $currentRoute = request()->route()->getName();
@endphp

<ul class="space-y-1">
    @if($role === 'admin')
        <li>
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ $currentRoute === 'admin.dashboard' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ $currentRoute === 'admin.dashboard' ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="font-semibold">Dashboard</span>
            </a>
        </li>
        
        <li>
            <a href="{{ route('notifications.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'notifications') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'notifications') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="font-semibold">Notifications</span>
                @php
                    $unreadCount = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count();
                @endphp
                @if($unreadCount > 0)
                    <span class="ml-auto bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                @endif
            </a>
        </li>
        
        <li class="pt-4 pb-2">
            <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Management</p>
        </li>
        
        <li>
            <a href="{{ route('admin.tutors.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'admin.tutors') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'admin.tutors') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="font-semibold">Tutors</span>
            </a>
        </li>
        
        <li>
            <a href="{{ route('admin.clients.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
             
             
             
               {{ str_starts_with($currentRoute, 'admin.clients') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'admin.clients') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span class="font-semibold">Clients</span>
            </a>
        </li>
        
        <li>
            <a href="{{ route('admin.students.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'admin.students') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'admin.students') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span class="font-semibold">Students</span>
            </a>
        </li>
        
        <li>
            <a href="{{ route('admin.subjects.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'admin.subjects') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'admin.subjects') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span class="font-semibold">Subjects</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.grade-levels.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'admin.grade-levels') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'admin.grade-levels') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <span class="font-semibold">Grade Levels</span>
            </a>
        </li>
        
        <li class="pt-4 pb-2">
            <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Operations</p>
        </li>
        
        <li>
            <a href="{{ route('admin.schedules.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'admin.schedules') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'admin.schedules') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="font-semibold">Schedules</span>
            </a>
        </li>
        
        <li>
            <a href="{{ route('admin.salaries.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'admin.salaries') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'admin.salaries') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-semibold">Salaries</span>
            </a>
        </li>
        
        <li>
            <a href="{{ route('admin.payments.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'admin.payments') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'admin.payments') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zm11 0a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                <span class="font-semibold">Payments</span>
            </a>
        </li>
        
        <li class="pt-4 pb-2">
            <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Analytics</p>
        </li>
        
        <li>
            <a href="{{ route('admin.reports.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'admin.reports') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'admin.reports') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span class="font-semibold">Reports</span>
            </a>
        </li>

        <li>
            <a href="{{ route('admin.session-reports.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'admin.session-reports') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'admin.session-reports') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="font-semibold">Laporan Sesi</span>
            </a>
        </li>
        

        
        <li>
            <a href="{{ route('admin.student-progress.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'admin.student-progress') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'admin.student-progress') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span class="font-semibold">Student Progress</span>
            </a>
        </li>
        
    @elseif($role === 'tutor')
        <li>
            <a href="{{ route('tutor.dashboard') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ $currentRoute === 'tutor.dashboard' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ $currentRoute === 'tutor.dashboard' ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="font-semibold">Dashboard</span>
            </a>
        </li>
        
        <li class="pt-4 pb-2">
            <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Teaching</p>
        </li>
        
        <li>
            <a href="{{ route('tutor.schedules.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'tutor.schedules') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'tutor.schedules') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="font-semibold">My Schedules</span>
            </a>
        </li>
        
        <li>
            <a href="{{ route('tutor.reports.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'tutor.reports') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'tutor.reports') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="font-semibold">Session Reports</span>
            </a>
        </li>
        
        <li>
            <a href="{{ route('tutor.students.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'tutor.students') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'tutor.students') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span class="font-semibold">My Students</span>
            </a>
        </li>
        
        <li class="pt-4 pb-2">
            <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Earnings</p>
        </li>
        
        <li>
            <a href="{{ route('tutor.earnings.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'tutor.earnings') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'tutor.earnings') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-semibold">My Earnings</span>
            </a>
        </li>
        
    @elseif($role === 'client')
        <li>
            <a href="{{ route('client.dashboard') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ $currentRoute === 'client.dashboard' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ $currentRoute === 'client.dashboard' ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="font-semibold">Dashboard</span>
            </a>
        </li>
        
        <li class="pt-4 pb-2">
            <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Keluarga Saya</p>
        </li>
        
        <li>
            <a href="{{ route('client.children.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'client.children') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'client.children') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="font-semibold">Data Anak</span>
            </a>
        </li>
        
        <li class="pt-4 pb-2">
            <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Pembelajaran</p>
        </li>
        
        <li>
            <a href="{{ route('client.schedules.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'client.schedules') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'client.schedules') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="font-semibold">Jadwal Belajar</span>
            </a>
        </li>
        
        <li>
            <a href="{{ route('client.progress.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'client.progress') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'client.progress') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                <span class="font-semibold">Perkembangan</span>
            </a>
        </li>
        
        <li>
            <a href="{{ route('client.reports.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'client.reports') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'client.reports') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="font-semibold">Laporan Sesi</span>
            </a>
        </li>
        
        <li class="pt-4 pb-2">
            <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Keuangan</p>
        </li>
        
        <li>
            <a href="{{ route('client.payments.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
               {{ str_starts_with($currentRoute, 'client.payments') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
                <svg class="h-5 w-5 {{ str_starts_with($currentRoute, 'client.payments') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zm11 0a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                <span class="font-semibold">Pembayaran</span>
            </a>
        </li>
    @endif
</ul>
