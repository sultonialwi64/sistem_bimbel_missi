@extends('layouts.app')

@section('title', 'Manage Tutors')
@section('page-title', 'Tutor Management')
@section('page-subtitle', 'Manage tutors and their information')

@section('content')
<div class="space-y-8">
    <!-- Header Action -->
    <div class="flex justify-between items-center">
        <div>
            <p class="text-gray-500">Manage tutors and their information</p>
        </div>
        <a href="{{ route('admin.tutors.create') }}" class="btn-primary-gradient text-white font-bold px-6 py-3 rounded-2xl hover:shadow-2xl flex items-center gap-3 shadow-xl shadow-indigo-500/30">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Tutor
        </a>
    </div>

    <!-- Search & Filter Card -->
    <div class="card-premium p-6">
        <form class="flex gap-4 flex-wrap">
            <div class="flex-1 min-w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tutors by name or email..." 
                       class="input-premium" />
            </div>
            <select name="status" class="input-premium w-48">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
            </select>
            <button type="submit" class="btn-secondary px-6 py-3 rounded-2xl font-bold">
                Filter
            </button>
        </form>
    </div>

    <!-- Tutors Table -->
    <div class="card-premium overflow-hidden">
        <!-- Gradient Header Bar -->
        <div class="bg-indigo-800 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    All Tutors
                </h3>
                <span class="text-blue-100 text-sm font-semibold">{{ $tutors->total() }} tutors found</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th class="text-left py-4 px-6">Tutor</th>
                        <th class="text-left py-4 px-6">Specialization</th>
                        <th class="text-left py-4 px-6">Rating</th>
                        <th class="text-left py-4 px-6">Sessions</th>
                        <th class="text-left py-4 px-6">Status</th>
                        <th class="text-right py-4 px-6">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tutors as $tutor)
                        <tr class="group">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/20 group-hover:shadow-xl group-hover:shadow-blue-500/30 transition-all">
                                        <span class="text-white font-bold text-sm">{{ substr($tutor->user->name, 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $tutor->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $tutor->user->email }}</p>
                                        @if($tutor->user->phone)
                                            <p class="text-xs text-gray-400">{{ $tutor->user->phone }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="space-y-1">
                                    @foreach(array_slice($tutor->specialization ?? [], 0, 2) as $spec)
                                        <span class="inline-flex items-center px-2.5 py-1 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 text-blue-700 rounded-lg text-xs font-semibold">
                                            {{ $spec }}
                                        </span>
                                    @endforeach
                                    @if(count($tutor->specialization ?? []) > 2)
                                        <span class="text-xs text-gray-400">+{{ count($tutor->specialization ?? []) - 2 }} more</span>
                                    @endif
                                </div>
                                @if($tutor->education)
                                    <p class="text-xs text-gray-500 mt-1">{{ $tutor->education }}</p>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    <svg class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="text-lg font-black text-gray-900">{{ number_format($tutor->rating_avg, 2) }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ $tutor->tier }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-base font-bold text-gray-900">{{ $tutor->total_sessions }}</p>
                                <p class="text-xs text-gray-500">total sessions</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold
                                    @if($tutor->status === 'active') bg-gradient-to-r from-green-50 to-emerald-50 text-green-700 border border-green-200
                                    @elseif($tutor->status === 'inactive') bg-gradient-to-r from-gray-50 to-gray-100 text-gray-700 border border-gray-200
                                    @else bg-gradient-to-r from-red-50 to-pink-50 text-red-700 border border-red-200
                                    @endif">
                                    @if($tutor->status === 'active')
                                        <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                    {{ ucfirst($tutor->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.tutors.show', $tutor) }}" 
                                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-50 text-indigo-700 border border-indigo-100 rounded-xl font-semibold text-sm hover:bg-indigo-50 transition-all">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ route('admin.tutors.edit', $tutor) }}" 
                                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-50 text-amber-700 border border-amber-100 rounded-xl font-semibold text-sm hover:bg-amber-50 transition-all">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.tutors.destroy', $tutor) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this tutor?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-50 text-red-700 border border-red-100 rounded-xl font-semibold text-sm hover:bg-red-50 transition-all">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="h-20 w-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-semibold">No tutors found</p>
                                    <p class="text-gray-400 text-sm mt-1">Start by adding a new tutor</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($tutors->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $tutors->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
