@extends('layouts.app')

@section('title', 'Subjects')
@section('page-title', 'Subject Management')
@section('page-subtitle', 'Manage subjects and levels')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <div>
            <p class="text-gray-500 text-sm">Manage subjects and levels</p>
        </div>
        <a href="{{ route('admin.subjects.create') }}" class="btn-primary-gradient text-white font-bold px-5 py-2.5 rounded-2xl hover:shadow-2xl flex items-center gap-2 shadow-xl shadow-indigo-500/30 w-full sm:w-auto justify-center">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Subject
        </a>
    </div>

    <div class="card-premium overflow-hidden">
        <div class="bg-indigo-800 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    All Subjects
                </h3>
                <span class="text-indigo-100 text-sm font-semibold">{{ $subjects->total() }} subjects</span>
            </div>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th class="text-left py-4 px-6">Subject Name</th>
                        <th class="text-left py-4 px-6">Level</th>
                        <th class="text-left py-4 px-6">Description</th>
                        <th class="text-left py-4 px-6">Status</th>
                        <th class="text-right py-4 px-6">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $subject)
                        <tr class="group">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center shadow-sm">
                                        <svg class="h-5 w-5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </div>
                                    <p class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $subject->name }}</p>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-3 py-1.5 bg-indigo-50 border border-indigo-100 text-indigo-700 rounded-full text-xs font-bold">
                                    {{ $subject->gradeLevel->name ?? '-' }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm text-gray-600 max-w-md">{{ Str::limit($subject->description, 60) ?? '-' }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold
                                    @if($subject->is_active) bg-gradient-to-r from-green-50 to-emerald-50 text-green-700 border border-green-200
                                    @else bg-gradient-to-r from-gray-50 to-gray-100 text-gray-700 border border-gray-200
                                    @endif">
                                    {{ $subject->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.subjects.edit', $subject) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-50 text-indigo-700 border border-indigo-100 rounded-xl font-semibold text-sm hover:bg-indigo-50 transition-all">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-50 text-red-700 border border-red-100 rounded-xl font-semibold text-sm hover:bg-red-50 transition-all">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <p class="text-gray-500 font-semibold">No subjects found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Card List --}}
        <div class="sm:hidden p-4 space-y-3">
            @forelse($subjects as $subject)
                <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm">
                    <div class="flex items-start gap-3 mb-3">
                        <div class="h-10 w-10 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center flex-shrink-0">
                            <svg class="h-5 w-5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-start justify-between gap-2">
                                <p class="font-bold text-gray-900 text-sm">{{ $subject->name }}</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold flex-shrink-0
                                    @if($subject->is_active) bg-green-100 text-green-700
                                    @else bg-gray-100 text-gray-600
                                    @endif">
                                    {{ $subject->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="inline-flex items-center px-2 py-0.5 bg-indigo-50 border border-indigo-100 text-indigo-700 rounded-full text-[10px] font-bold">
                                    {{ $subject->gradeLevel->name ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($subject->description)
                        <p class="text-xs text-gray-500 mb-3 line-clamp-2">{{ $subject->description }}</p>
                    @endif

                    <div class="flex items-center gap-2 pt-3 border-t border-gray-50">
                        <a href="{{ route('admin.subjects.edit', $subject) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 bg-indigo-50 text-indigo-700 rounded-xl font-semibold text-xs hover:bg-indigo-100 transition-all">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit
                        </a>
                        <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST" class="inline flex-1" onsubmit="return confirm('Hapus subject ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 py-2 bg-red-50 text-red-700 rounded-xl font-semibold text-xs hover:bg-red-100 transition-all">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-gray-500 font-semibold">No subjects found</p>
                </div>
            @endforelse
        </div>

        @if($subjects->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $subjects->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
