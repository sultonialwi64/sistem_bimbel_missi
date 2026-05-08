@extends('layouts.app')
@section('title', 'Session Reports')
@section('page-title', 'Session Reports')
@section('page-subtitle', 'View all your session reports')

@section('content')
<div class="space-y-6">
    <div class="card-premium">
        <div class="table-container">
            <table class="table-premium">
                <thead class="bg-indigo-900">
                    <tr>
                        <th class="text-white font-bold opacity-90">Date</th>
                        <th class="text-white font-bold opacity-90">Student</th>
                        <th class="text-white font-bold opacity-90">Subject</th>
                        <th class="text-white font-bold opacity-90">Understanding</th>
                        <th class="text-white font-bold opacity-90 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td><span class="text-sm font-semibold text-gray-900">{{ $report->created_at->format('d M Y') }}</span></td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar-gradient bg-gradient-to-br from-purple-500 to-pink-600 shadow-purple-500/20">
                                        <span>{{ substr($report->student->name, 0, 2) }}</span>
                                    </div>
                                    <span class="font-bold text-gray-900">{{ $report->student->name }}</span>
                                </div>
                            </td>
                            <td><span class="text-sm text-gray-700">{{ $report->schedule->subject->name }}</span></td>
                            <td>
                                <span class="badge
                                    @if($report->student_understanding >= 4) badge-green
                                    @elseif($report->student_understanding >= 3) badge-amber
                                    @else badge-red @endif">
                                    {{ $report->student_understanding }}/5
                                </span>
                            </td>
                            <td>
                                <div class="flex justify-end">
                                    <a href="{{ route('tutor.reports.show', $report) }}" class="btn-icon text-indigo-600 hover:bg-indigo-50"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5"><div class="empty-state"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg><p class="font-semibold">No reports found</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $reports->links() }}</div>
</div>
@endsection
