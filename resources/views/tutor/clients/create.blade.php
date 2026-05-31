@extends('layouts.app')

@section('title', 'Tambah Client Baru')
@section('page-title', 'Tambah Client Baru')
@section('page-subtitle', 'Daftarkan klien / wali murid baru ke dalam sistem')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <a href="{{ route('tutor.clients.index') }}" class="back-link">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar Client
    </a>

    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 flex gap-3">
            <svg class="h-5 w-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="text-sm font-semibold text-red-700 mb-1">Terdapat kesalahan:</p>
                <ul class="text-sm text-red-600 space-y-1 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('tutor.clients.store') }}" method="POST" autocomplete="off">
        @csrf
        <div class="space-y-6">

            {{-- Informasi Akun --}}
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
                            <input type="text" name="name" value="{{ old('name') }}" required autocomplete="off"
                                   class="input-premium @error('name') border-red-500 @enderror"
                                   placeholder="Nama lengkap wali murid">
                            @error('name')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="form-label">Email <span class="text-red-500">*</span></label>
                            {{-- Trick to prevent browser autofill --}}
                            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="new-password"
                                   class="input-premium @error('email') border-red-500 @enderror"
                                   placeholder="email@example.com">
                            @error('email')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="form-label">Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" required autocomplete="new-password"
                                   class="input-premium @error('password') border-red-500 @enderror"
                                   placeholder="Minimal 8 karakter">
                            @error('password')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" autocomplete="off"
                                   class="input-premium"
                                   placeholder="08xxxxxxxxx">
                            @error('phone')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informasi Alamat --}}
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
                            <input type="text" name="emergency_contact" value="{{ old('emergency_contact') }}" autocomplete="off"
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
                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Tipe Klien
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">Tipe Klien <span class="text-red-500">*</span></label>
                            <select name="client_type" required class="input-premium @error('client_type') border-red-500 @enderror">
                                <option value="tipe_2" {{ old('client_type', 'tipe_2') == 'tipe_2' ? 'selected' : '' }}>Tipe 2</option>
                                <option value="tipe_1" {{ old('client_type') == 'tipe_1' ? 'selected' : '' }}>Tipe 1</option>
                            </select>
                            @error('client_type')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('tutor.clients.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Client
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
