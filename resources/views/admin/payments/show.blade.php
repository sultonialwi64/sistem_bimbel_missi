@extends('layouts.app')

@section('title', 'Payment Detail')
@section('page-title', 'Payment Detail')

@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ $returnUrl }}" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block">&larr; Back to Payments</a>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="text-sm text-gray-500">Client</label>
                <p class="text-lg font-semibold">{{ $payment->client->user->name }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-500">Student</label>
                <p class="text-lg font-semibold">{{ $payment->student->name }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-500">Amount</label>
                <p class="text-lg font-semibold text-green-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-500">Payment Method</label>
                <p class="text-lg font-semibold">{{ $payment->payment_method ?? '-' }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-500">Payment Date</label>
                <p class="text-lg font-semibold">{{ $payment->payment_date ? $payment->payment_date->format('d M Y') : '-' }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-500">Due Date</label>
                <p class="text-lg font-semibold">{{ $payment->due_date->format('d M Y') }}</p>
            </div>
        </div>

        <div class="flex items-center justify-between border-t pt-6">
            <div>
                <span class="px-3 py-1 rounded-full text-sm {{ $payment->status === 'paid' ? 'bg-green-100 text-green-800' : ($payment->status === 'overdue' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                    {{ ucfirst($payment->status) }}
                </span>
            </div>
            @if($payment->status === 'pending')
                <form action="{{ route('admin.payments.verify', $payment) }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="hidden" name="return_url" value="{{ $returnUrl }}">
                    <select name="status" required class="rounded-md border-gray-300">
                        <option value="paid">Mark as Paid</option>
                        <option value="overdue">Mark as Overdue</option>
                        <option value="cancelled">Cancel</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Verify</button>
                </form>
            @endif
        </div>

        @if($payment->payment_proof)
            <div class="mt-6">
                <label class="text-sm text-gray-500">Payment Proof</label>
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $payment->payment_proof) }}" class="h-48 rounded border">
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
