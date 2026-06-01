@extends('layouts.app')

@section('title', 'Client Detail')
@section('page-title', $client->user->name)

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Back Button -->
    <a href="{{ route('tutor.clients.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Clients
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-center">
                    <img class="h-24 w-24 rounded-full mx-auto" src="{{ $client->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($client->user->name) . '&size=128' }}" alt="">
                    <h2 class="mt-4 text-xl font-bold text-gray-800">{{ $client->user->name }}</h2>
                    <p class="text-gray-500">{{ $client->user->email }}</p>
                    <p class="text-gray-500">{{ $client->user->phone ?? '-' }}</p>
                    
                    <div class="mt-4 flex justify-center gap-2">
                        <a href="{{ route('tutor.clients.edit', $client) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
                            Edit
                        </a>
                        <form action="{{ route('tutor.clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Stats -->
                <div class="mt-6 pt-6 border-t">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-indigo-600">{{ $client->students->count() }}</p>
                        <p class="text-xs text-gray-500">Children</p>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <h3 class="font-semibold text-gray-800 mb-4">Contact Information</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <label class="text-gray-500">Emergency Contact</label>
                        <p class="font-medium">{{ $client->emergency_contact ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-500">Ditambahkan Oleh</label>
                        <p class="font-medium">{{ $client->createdBy?->name ?? 'Data lama / tidak tercatat' }}</p>
                    </div>
                    <div>
                        <label class="text-gray-500">Tanggal Ditambahkan</label>
                        <p class="font-medium">{{ $client->created_at?->translatedFormat('d F Y H:i') ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Address -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Address</h3>
                <p class="text-gray-700">{{ $client->address }}</p>
                @if($client->address_lat && $client->address_lng)
                    <a href="https://www.google.com/maps?q={{ $client->address_lat }},{{ $client->address_lng }}" 
                       target="_blank"
                       class="inline-flex items-center mt-2 text-indigo-600 hover:text-indigo-800">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Open in Google Maps
                    </a>
                @endif
            </div>

            <!-- Children -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-gray-800">Children</h3>
                    <a href="{{ route('tutor.students.create') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Add Child</a>
                </div>
                <div class="space-y-3">
                    @forelse($client->students as $student)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <img src="{{ $student->photo ? asset('storage/' . $student->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&size=40' }}" 
                                     class="h-10 w-10 rounded-full">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $student->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $student->grade_level }} - {{ $student->school_name }}</p>
                                </div>
                            </div>
                            <a href="{{ route('tutor.students.show', $student) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No children yet</p>
                    @endforelse
                </div>
            </div>

            <!-- Payment History -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-gray-800">Payment History</h3>
                    <a href="{{ route('tutor.payments.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View All</a>
                </div>
                <div class="space-y-3">
                    @forelse($client->payments()->latest()->take(5)->get() as $payment)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-800">{{ $payment->student->name }}</p>
                                <p class="text-sm text-gray-500">{{ $payment->payment_method }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-gray-800">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($payment->status === 'paid') bg-green-100 text-green-800
                                    @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No payments yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
