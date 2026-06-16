@extends('layouts.app')

@section('title', 'Edit Tutor')
@section('page-title', 'Edit Tutor')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.tutors.update', $tutor) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Personal Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Personal Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $tutor->user->name) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email', $tutor->user->email) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">New Password (leave empty to keep current)</label>
                            <input type="password" name="password"
                                   class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="text-xs text-gray-500 mt-1">Leave empty to keep current password</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $tutor->user->phone) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>

                <!-- Professional Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Professional Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Spesialisasi <span class="text-red-500">*</span></label>
                            <select id="specialization-select" name="specialization[]" multiple placeholder="Pilih atau ketik spesialisasi baru..." class="mt-1 w-full">
                                @php $currentSpecs = $tutor->specialization ?? []; @endphp
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject }}" {{ in_array($subject, $currentSpecs) ? 'selected' : '' }}>{{ $subject }}</option>
                                @endforeach
                                {{-- Custom specs that are not in subjects list --}}
                                @foreach(array_diff($currentSpecs, $subjects->toArray()) as $custom)
                                    <option value="{{ $custom }}" selected>{{ $custom }}</option>
                                @endforeach
                            </select>
                            @error('specialization')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                            <p class="text-xs text-gray-400 mt-1">Pilih dari daftar atau ketik nama baru lalu tekan Enter.</p>
                        </div>
                        

                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="active" {{ $tutor->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $tutor->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="suspended" {{ $tutor->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                        </div>

                        <div class="col-span-2 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-sm font-semibold text-gray-800">Landing Page</p>
                            <p class="mt-1 text-xs leading-6 text-gray-500">Pilih apakah tutor ini masuk 4 card utama landing page dan atur urutannya.</p>

                            <div class="mt-4 grid gap-4 md:grid-cols-2">
                                <label class="flex items-start gap-3 rounded-xl border border-slate-200 bg-white p-3">
                                    <input type="checkbox" name="is_featured_on_landing" value="1" {{ old('is_featured_on_landing', $tutor->is_featured_on_landing) ? 'checked' : '' }} class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                    <span>
                                        <span class="block text-sm font-semibold text-gray-800">Tampilkan di landing page</span>
                                        <span class="block text-xs text-gray-500">Tutor ini diprioritaskan muncul di card utama.</span>
                                    </span>
                                </label>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Urutan Landing</label>
                                    <input type="number" name="landing_feature_order" min="1" max="20" value="{{ old('landing_feature_order', $tutor->landing_feature_order) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: 1">
                                    <p class="mt-1 text-xs text-gray-500">Semakin kecil angkanya, semakin atas posisinya.</p>
                                    @error('landing_feature_order')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Education</label>
                            <input type="text" name="education" value="{{ old('education', $tutor->education) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Bio</label>
                            <textarea name="bio" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('bio', $tutor->bio) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Bank Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Bank Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bank Name</label>
                            <input type="text" name="bank_name" value="{{ old('bank_name', $tutor->bank_name) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bank Account</label>
                            <input type="text" name="bank_account" value="{{ old('bank_account', $tutor->bank_account) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3 pt-4 border-t">
                    <a href="{{ route('admin.tutors.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        Update Tutor
                    </button>
                </div>
            </div>
        </form>
    </div>
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
