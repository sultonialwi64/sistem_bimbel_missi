@extends('layouts.app')

@section('title', 'Tutor Detail')
@section('page-title', $tutor->user->name)
@section('page-subtitle', 'Tutor profile and performance details')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Back -->
    <a href="{{ route('admin.tutors.index') }}" class="back-link">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to Tutors
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1 space-y-6">
            <div class="card-premium">
                <div class="h-24 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 relative">
                    <div class="absolute -bottom-12 left-1/2 -translate-x-1/2">
                        <img class="h-24 w-24 rounded-2xl object-cover border-4 border-white shadow-xl" 
                             src="{{ $tutor->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($tutor->user->name) . '&background=205085&color=fff&size=128' }}" alt="">
                    </div>
                </div>
                <div class="pt-16 pb-6 px-6 text-center">
                    <h2 class="text-xl font-black text-gray-900">{{ $tutor->user->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $tutor->user->email }}</p>
                    <p class="text-sm text-gray-400">{{ $tutor->user->phone }}</p>
                    
                    <div class="mt-4">
                        <span class="badge
                            @if($tutor->status === 'active') badge-green
                            @elseif($tutor->status === 'inactive') badge-gray
                            @else badge-red @endif">
                            {{ ucfirst($tutor->status) }}
                        </span>
                    </div>

                    <div class="mt-3">
                        @if($tutor->is_featured_on_landing)
                            <span class="badge badge-indigo">Landing page #{{ $tutor->landing_feature_order ?? '-' }}</span>
                        @else
                            <span class="badge badge-gray">Tidak tampil di landing</span>
                        @endif
                    </div>

                    <div class="mt-5 flex justify-center gap-2">
                        <a href="{{ route('admin.tutors.edit', $tutor) }}" class="btn-primary text-sm">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit
                        </a>
                        <form action="{{ route('admin.tutors.destroy', $tutor) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger text-sm">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Stats -->
                <div class="px-6 pb-6">
                    <div class="grid grid-cols-2 gap-4 p-4 bg-gradient-to-r from-gray-50 to-white rounded-2xl border border-gray-100">
                        <div class="text-center">
                            <p class="text-2xl font-black text-indigo-600">{{ $tutor->total_sessions }}</p>
                            <p class="text-xs text-gray-500 font-semibold">Sessions</p>
                        </div>
                        <div class="text-center">
                            <div class="flex items-center justify-center gap-1">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="text-2xl font-black text-gray-900">{{ number_format($tutor->rating_avg, 1) }}</span>
                            </div>
                            <p class="text-xs text-gray-500 font-semibold">Rating</p>
                        </div>
                    </div>
                    <p class="text-center text-sm text-gray-600 mt-3">Tier: <span class="font-bold text-indigo-600">{{ $tutor->tier }}</span></p>
                </div>
            </div>

            <!-- Specializations -->
            <div class="card-premium p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    Specializations
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($tutor->specialization ?? [] as $spec)
                        <span class="badge badge-indigo">{{ $spec }}</span>
                    @endforeach
                </div>
            </div>

            <!-- Bank Info -->
            <div class="card-premium p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    Bank Information
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between p-3 bg-gray-50 rounded-xl"><span class="text-sm text-gray-500">Bank</span><span class="text-sm font-bold text-gray-900">{{ $tutor->bank_name ?? '-' }}</span></div>
                    <div class="flex justify-between p-3 bg-gray-50 rounded-xl"><span class="text-sm text-gray-500">Account</span><span class="text-sm font-bold text-gray-900">{{ $tutor->bank_account ?? '-' }}</span></div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- About -->
            <div class="card-premium p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    About
                </h3>
                <div class="space-y-4">
                    <div class="p-4 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100">
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wide">Education</label>
                        <p class="text-gray-900 mt-1 font-medium">{{ $tutor->education ?? '-' }}</p>
                    </div>
                    <div class="p-4 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100">
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wide">Teaching Experience</label>
                        <p class="text-gray-900 mt-1 font-medium">
                            {{ $tutor->teaching_experience_label ?? '-' }}
                        </p>
                    </div>
                    <div class="p-4 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100">
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wide">Bio</label>
                        <p class="text-gray-900 mt-1">{{ $tutor->bio ?? 'No bio available' }}</p>
                    </div>
                </div>
            </div>

            <!-- Recent Schedules -->
            <div class="card-premium">
                <div class="section-header-blue">
                    <div class="flex items-center justify-between">
                        <h3 class="section-header-title">
                            <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Recent Schedules
                        </h3>
                        <a href="{{ route('admin.schedules.index') }}" class="section-header-link">View All <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
                    </div>
                </div>
                <div class="p-6 space-y-3">
                    @forelse($tutor->schedules()->with(['student', 'subject'])->latest()->take(5)->get() as $schedule)
                        <div class="list-item-premium">
                            <div class="flex items-center gap-3">
                                <div class="avatar-gradient bg-gradient-to-br from-blue-500 to-indigo-600 shadow-blue-500/20"><span>{{ substr($schedule->student->name, 0, 2) }}</span></div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $schedule->student->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $schedule->subject->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-700">{{ $schedule->date->format('d M Y') }}</p>
                                <span class="badge @if($schedule->status === 'completed') badge-green @elseif($schedule->status === 'scheduled') badge-blue @else badge-gray @endif">{{ ucfirst($schedule->status) }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state"><p class="font-semibold text-gray-500">No schedules yet</p></div>
                    @endforelse
                </div>
            </div>

            <!-- Salary History -->
            <div class="card-premium">
                <div class="section-header-green">
                    <div class="flex items-center justify-between">
                        <h3 class="section-header-title">
                            <svg class="h-5 w-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Salary History
                        </h3>
                        <a href="{{ route('admin.salaries.index') }}" class="section-header-link">View All <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
                    </div>
                </div>
                <div class="p-6 space-y-3">
                    @forelse($tutor->salaries()->latest()->take(5)->get() as $salary)
                        <div class="list-item-premium">
                            <div>
                                <p class="font-bold text-gray-900">{{ $salary->period_start->format('d M') }} - {{ $salary->period_end->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $salary->total_sessions }} sessions</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-black text-gray-900">Rp {{ number_format($salary->total_amount, 0, ',', '.') }}</p>
                                <span class="badge @if($salary->status === 'paid') badge-green @elseif($salary->status === 'pending') badge-amber @else badge-gray @endif">{{ ucfirst($salary->status) }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state"><p class="font-semibold text-gray-500">No salary records yet</p></div>
                    @endforelse
                </div>
            </div>
            <!-- Recent Reviews & Ratings -->
            <div class="card-premium">
                <div class="bg-gradient-to-r from-amber-500 via-orange-500 to-amber-600 px-6 py-4 border-b border-amber-600">
                    <div class="flex items-center justify-between">
                        <h3 class="font-bold text-white flex items-center gap-2">
                            <svg class="h-5 w-5 text-amber-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            Recent Reviews & Ratings
                        </h3>
                    </div>
                </div>
                <div class="p-6 space-y-4 bg-amber-50/30">
                    @php
                        $recentReviews = \App\Models\SessionReport::where('tutor_id', $tutor->id)
                            ->whereNotNull('parent_rating')
                            ->with(['student.client.user'])
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp
                    @forelse($recentReviews as $review)
                        <div class="bg-white p-4 rounded-xl border border-amber-100 shadow-sm">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="font-bold text-sm text-gray-900">{{ $review->student->client->user->name ?? 'Orang Tua' }} <span class="text-xs font-normal text-gray-500">(Wali dari {{ $review->student->name }})</span></p>
                                    <div class="flex items-center gap-1 mt-1">
                                        @for($i=1; $i<=5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->parent_rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                        <span class="text-xs font-bold ml-1 text-amber-600">{{ $review->parent_rating }}/5</span>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            
                            @if($review->parent_feedback)
                            <div class="mt-3 text-sm text-gray-700 italic bg-gray-50 p-3 rounded-lg border border-gray-100 relative">
                                <span class="absolute -top-2 left-2 text-xl text-gray-300">"</span>
                                {{ $review->parent_feedback }}
                                <span class="absolute -bottom-4 right-2 text-xl text-gray-300">"</span>
                            </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-6 bg-white rounded-xl border border-dashed border-amber-200">
                            <div class="inline-flex justify-center items-center w-12 h-12 rounded-full bg-amber-50 mb-2">
                                <svg class="w-6 h-6 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </div>
                            <p class="text-sm font-medium text-amber-800">Belum ada review</p>
                            <p class="text-xs text-amber-600 mt-1">Belum ada penilaian dari wali murid untuk tutor ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
