@extends('layouts.app')

@section('title', 'Add New Client')
@section('page-title', 'Add New Client')
@section('page-subtitle', 'Register a new client/parent in the system')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <a href="{{ route('admin.clients.index') }}" class="back-link">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to Clients
    </a>

    <form action="{{ route('admin.clients.store') }}" method="POST">
        @csrf
        <div class="space-y-6">

            {{-- Personal Information --}}
            <div class="form-section">
                <div class="form-accent bg-gradient-to-b from-indigo-500 to-purple-600"></div>
                <div class="pl-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Informasi Akun
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   class="input-premium @error('name') border-red-500 @enderror"
                                   placeholder="Nama lengkap wali murid">
                            @error('name')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="form-label">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="input-premium @error('email') border-red-500 @enderror"
                                   placeholder="email@example.com">
                            @error('email')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="form-label">Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" required
                                   class="input-premium @error('password') border-red-500 @enderror"
                                   placeholder="Minimal 8 karakter">
                            @error('password')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="input-premium"
                                   placeholder="08xxxxxxxxx">
                            @error('phone')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Address Information --}}
            <div class="form-section">
                <div class="form-accent bg-gradient-to-b from-blue-500 to-cyan-600"></div>
                <div class="pl-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Informasi Alamat
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="form-label">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="address" rows="3" required
                                      class="textarea-premium @error('address') border-red-500 @enderror"
                                      placeholder="Jl. Contoh No. 1, RT/RW, Kelurahan, Kecamatan, Kota">{{ old('address') }}</textarea>
                            @error('address')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="form-label">Kontak Darurat</label>
                            <input type="text" name="emergency_contact" value="{{ old('emergency_contact') }}"
                                   class="input-premium"
                                   placeholder="08xxxxxxxxx">
                            @error('emergency_contact')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tipe Klien --}}
            <div class="form-section">
                <div class="form-accent bg-gradient-to-b from-green-500 to-emerald-600"></div>
                <div class="pl-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Tipe Klien & Harga Sesi
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">Tipe Klien <span class="text-red-500">*</span></label>
                            <select name="client_type" required class="input-premium @error('client_type') border-red-500 @enderror">
                                <option value="tipe_2" {{ old('client_type') == 'tipe_2' ? 'selected' : '' }}>Tipe 2 — Rp 50.000 / sesi</option>
                                <option value="tipe_1" {{ old('client_type') == 'tipe_1' ? 'selected' : '' }}>Tipe 1 — Rp 45.000 / sesi</option>
                            </select>
                            @error('client_type')<p class="form-error">{{ $message }}</p>@enderror
                            <p class="text-xs text-gray-400 mt-1">Tipe ini menentukan tagihan klien & margin perusahaan secara otomatis. Tutor tetap menerima Rp 40.000/sesi.</p>
                        </div>
                        <div class="flex items-start gap-3 bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4 mt-0 md:mt-6">
                            <svg class="h-5 w-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div class="text-xs text-green-800 space-y-1">
                                <p class="font-bold">Catatan Bagi Hasil:</p>
                                <p>• Tipe 2 (Rp 50.000): Tutor Rp 40.000 · Perusahaan Rp 10.000</p>
                                <p>• Tipe 1 (Rp 45.000): Tutor Rp 40.000 · Perusahaan Rp 5.000</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.clients.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Client
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
