@extends('layouts.app')

@section('title', 'Add Tutor')
@section('page-title', 'Add New Tutor')
@section('page-subtitle', 'Register a new tutor in the system')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <a href="{{ route('admin.tutors.index') }}" class="back-link">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to Tutors
    </a>

    <form action="{{ route('admin.tutors.store') }}" method="POST">
        @csrf
        <div class="space-y-6">
            <!-- Account Info -->
            <div class="form-section">
                <div class="form-accent bg-gradient-to-b from-indigo-500 to-purple-600"></div>
                <div class="pl-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Account Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="input-premium @error('name') border-red-500 @enderror" placeholder="Enter full name">
                            @error('name')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="input-premium @error('email') border-red-500 @enderror" placeholder="tutor@example.com">
                            @error('email')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="input-premium" placeholder="08xxxxxxxxx">
                            @error('phone')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label">Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" required class="input-premium @error('password') border-red-500 @enderror" placeholder="Minimum 8 characters">
                            @error('password')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Info -->
            <div class="form-section">
                <div class="form-accent bg-gradient-to-b from-blue-500 to-cyan-600"></div>
                <div class="pl-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Professional Details
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">Education</label>
                            <input type="text" name="education" value="{{ old('education') }}" class="input-premium" placeholder="e.g. S1 Matematika">
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 md:row-span-2">
                            <p class="text-sm font-bold text-gray-900">Landing Page</p>
                            <p class="mt-1 text-xs leading-6 text-gray-500">Admin dapat memilih tutor ini tampil di 4 card utama landing page.</p>

                            <label class="mt-4 flex items-start gap-3">
                                <input type="checkbox" name="is_featured_on_landing" value="1" {{ old('is_featured_on_landing') ? 'checked' : '' }} class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                <span>
                                    <span class="block text-sm font-semibold text-gray-800">Tampilkan di landing page</span>
                                    <span class="block text-xs text-gray-500">Tutor ini masuk kandidat 4 tutor utama.</span>
                                </span>
                            </label>

                            <div class="mt-4">
                                <label class="form-label">Urutan Landing</label>
                                <input type="number" name="landing_feature_order" min="1" max="20" value="{{ old('landing_feature_order') }}" class="input-premium" placeholder="Contoh: 1">
                                <p class="mt-1 text-xs text-gray-500">Semakin kecil angkanya, semakin atas posisinya.</p>
                                @error('landing_feature_order')<p class="form-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="form-label">Spesialisasi <span class="text-red-500">*</span></label>
                            <select id="specialization-select" name="specialization[]" multiple placeholder="Pilih atau ketik spesialisasi baru..." class="@error('specialization') border-red-500 @enderror">
                                @php $oldSpec = old('specialization', []); @endphp
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject }}" {{ in_array($subject, $oldSpec) ? 'selected' : '' }}>{{ $subject }}</option>
                                @endforeach
                                {{-- Restore custom tags from old input that aren't in subjects list --}}
                                @foreach(array_diff($oldSpec, $subjects->toArray()) as $custom)
                                    <option value="{{ $custom }}" selected>{{ $custom }}</option>
                                @endforeach
                            </select>
                            @error('specialization')<p class="form-error">{{ $message }}</p>@enderror
                            <p class="text-xs text-gray-400 mt-1">Pilih dari daftar atau ketik nama baru lalu tekan Enter untuk menambahkan.</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="form-label">Bio</label>
                            <textarea name="bio" rows="3" class="textarea-premium" placeholder="Short biography...">{{ old('bio') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bank Info -->
            <div class="form-section">
                <div class="form-accent bg-gradient-to-b from-green-500 to-emerald-600"></div>
                <div class="pl-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        Bank Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">Bank Name</label>
                            <input type="text" name="bank_name" value="{{ old('bank_name') }}" class="input-premium" placeholder="e.g. BCA, Mandiri">
                        </div>
                        <div>
                            <label class="form-label">Account Number</label>
                            <input type="text" name="bank_account" value="{{ old('bank_account') }}" class="input-premium" placeholder="Account number">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.tutors.index') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Save Tutor
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<style>
    .ts-wrapper.multi .ts-control {
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 0.45rem 0.75rem;
        min-height: 2.75rem;
        box-shadow: none;
        transition: border-color 0.2s;
    }
    .ts-wrapper.multi .ts-control:focus-within {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
    }
    .ts-wrapper .ts-dropdown {
        border-radius: 0.5rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        border: 1px solid #e2e8f0;
        background-color: #ffffff !important;
        z-index: 9999 !important;
    }
    .ts-wrapper .ts-dropdown .option.selected { background-color: #6366f1; }
    .ts-wrapper .ts-dropdown .option:hover { background-color: #e0e7ff; color: #3730a3; }
    .ts-wrapper .ts-control .item {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border-radius: 9999px;
        padding: 2px 10px;
        font-size: 0.8rem;
        font-weight: 600;
        border: none;
    }
    .ts-wrapper .ts-control .item .remove { color: rgba(255,255,255,0.7); border-left: 1px solid rgba(255,255,255,0.3); }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect('#specialization-select', {
        create: true,
        createOnBlur: true,
        placeholder: 'Pilih atau ketik spesialisasi baru...',
        plugins: ['remove_button'],
        createFilter: function(input) {
            return input.length >= 2;
        },
        render: {
            option_create: function(data, escape) {
                return '<div class="create">Tambahkan <strong>' + escape(data.input) + '</strong>&hellip;</div>';
            }
        }
    });
</script>
@endpush
