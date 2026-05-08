@extends('layouts.app')

@section('title', 'Detail Jadwal')
@section('page-title', 'Detail Jadwal')

@section('content')
<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header -->
        <div class="bg-indigo-600 px-6 py-4">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">Jadwal #{{ $schedule->id }}</h2>
                <a href="{{ route('tutor.schedules.index') }}" class="text-white hover:text-indigo-200">
                    ← Kembali ke Jadwal
                </a>
            </div>
        </div>

        <div class="p-6">
            <!-- Schedule Info -->
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="text-sm text-gray-500">Siswa</label>
                    <p class="text-lg font-semibold">{{ $schedule->student->name }}</p>
                    <p class="text-sm text-gray-600">{{ $schedule->student->grade_level }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Mata Pelajaran</label>
                    <p class="text-lg font-semibold">{{ $schedule->subject->name }}</p>
                    <p class="text-sm text-gray-600">{{ $schedule->subject->level }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Tanggal & Waktu</label>
                    <p class="text-lg font-bold text-indigo-700">{{ $schedule->date->translatedFormat('l, d M Y') }}</p>
                    <p class="text-sm font-medium text-gray-600 bg-gray-100 px-3 py-1 rounded-lg inline-block mt-1">
                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB
                    </p>
                </div>
                <div>
                    <label class="text-sm text-gray-500">Status</label>
                    <p class="mt-1">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($schedule->status === 'completed') bg-green-100 text-green-800
                            @elseif($schedule->status === 'scheduled') bg-blue-100 text-blue-800
                            @elseif($schedule->status === 'cancelled') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst($schedule->status) }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Student Address -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="font-semibold mb-2">Alamat Siswa</h3>
                <p class="text-gray-700">{{ $schedule->student->client->address }}</p>

            </div>

            <!-- Attendance Section -->
            @php
                $attendance = $schedule->attendance;
                // === VALIDASI WAKTU ABSEN ===
                $scheduleDate  = $schedule->date->format('Y-m-d');
                // Selalu pakai tanggal dari $schedule->date, ambil hanya H:i:s dari start_time/end_time
                $sessionStart  = \Carbon\Carbon::parse($scheduleDate . ' ' . \Carbon\Carbon::parse($schedule->start_time)->format('H:i:s'));
                $sessionEnd    = \Carbon\Carbon::parse($scheduleDate . ' ' . \Carbon\Carbon::parse($schedule->end_time)->format('H:i:s'));
                $deadlineAbsen = $sessionEnd->copy()->addMinutes(90);
                $now = now();
                $canAbsen = $now->gte($sessionStart) && $now->lte($deadlineAbsen);
                $tooEarly = $now->lt($sessionStart);
                $tooLate  = $now->gt($deadlineAbsen);
            @endphp

            <div class="border-t pt-6" x-data="attendanceForm()">
                <h3 class="text-lg font-semibold mb-4">Absensi Sesi</h3>
                
                @if(!$attendance)
                    {{-- TIME WINDOW GUARD --}}
                    @if($tooEarly)
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 text-center">
                            <svg class="h-10 w-10 text-blue-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="font-bold text-blue-800 text-lg">Sesi Belum Dimulai</p>
                            <p class="text-blue-600 text-sm mt-1">Absensi baru bisa dilakukan mulai pukul <span class="font-bold">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} WIB</span></p>
                            <p class="text-blue-500 text-xs mt-2">Batas terakhir absen: {{ $deadlineAbsen->format('H:i') }} WIB (90 menit setelah sesi selesai)</p>
                        </div>
                    @elseif($tooLate)
                        <div class="bg-red-50 border border-red-200 rounded-xl p-5 text-center">
                            <svg class="h-10 w-10 text-red-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="font-bold text-red-800 text-lg">Waktu Absen Sudah Habis</p>
                            <p class="text-red-600 text-sm mt-1">Batas absensi adalah 90 menit setelah sesi selesai ({{ $deadlineAbsen->format('H:i') }} WIB).</p>
                            <p class="text-red-500 text-xs mt-2">Hubungi Admin jika ada kendala.</p>
                        </div>
                    @else
                    <form action="{{ route('tutor.attendance.submit', $schedule) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status Kehadiran <span class="text-red-500">*</span></label>
                            <select name="status" x-model="status" @change="handleStatusChange()" required 
                                    class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all">
                                <option value="">-- Pilih Status --</option>
                                <option value="hadir">Hadir di Lokasi</option>
                                <option value="pindah_lokasi">Pindah Lokasi</option>
                                <option value="libur_sakit">Libur / Sakit</option>
                                <option value="batal">Batal</option>
                            </select>
                        </div>

                        <div x-show="requiresPhoto" class="mb-4 space-y-4" style="display: none;">
                            <p class="text-sm text-gray-600">Ambil foto sebagai bukti kehadiran (Kamera Belakang/Depan).</p>
                            
                            <div x-show="!photoCaptured" class="relative bg-black rounded-xl overflow-hidden flex justify-center items-center shadow-inner" style="min-h: 300px;">
                                <video x-ref="video" autoplay playsinline class="w-full max-h-[60vh] object-contain"></video>
                                
                                <!-- Loading Lokasi Overlay -->
                                <div x-show="!locationLoaded" class="absolute top-4 left-4 bg-black/60 text-white px-3 py-1.5 rounded-lg text-xs flex items-center gap-2 backdrop-blur-sm">
                                    <svg class="animate-spin h-3 w-3 text-indigo-400" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Menunggu Lokasi...
                                </div>
                                <div x-show="locationLoaded" class="absolute top-4 left-4 bg-green-600/80 text-white px-3 py-1.5 rounded-lg text-xs flex items-center gap-2 backdrop-blur-sm">
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Lokasi Terdeteksi
                                </div>

                                <button type="button" @click="capturePhoto()" :disabled="!locationLoaded" 
                                        :class="{'opacity-50 cursor-not-allowed': !locationLoaded}"
                                        class="absolute bottom-6 left-1/2 transform -translate-x-1/2 bg-white text-indigo-600 rounded-full p-4 shadow-2xl border-4 border-indigo-100 hover:bg-indigo-50 transition-all hover:scale-105 active:scale-95">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </button>
                            </div>

                            <div x-show="photoCaptured" class="relative bg-gray-100 rounded-xl overflow-hidden flex flex-col justify-center items-center border border-gray-200" style="display: none;">
                                <canvas x-ref="canvas" class="w-full max-h-[60vh] object-contain"></canvas>
                                <div class="p-4 w-full flex justify-between items-center bg-white border-t border-gray-200">
                                    <button type="button" @click="retakePhoto()" class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm flex items-center gap-1.5 transition-colors">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        Ulangi Foto
                                    </button>
                                    <span class="text-sm font-bold text-green-600 flex items-center gap-1.5 bg-green-50 px-3 py-1.5 rounded-lg border border-green-200">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Foto Tersimpan
                                    </span>
                                </div>
                            </div>

                            <input type="hidden" name="photo_base64" x-model="photoBase64">
                            <input type="hidden" name="captured_at" x-model="capturedAt">
                            <input type="hidden" name="tutor_lat" x-model="latitude">
                            <input type="hidden" name="tutor_lng" x-model="longitude">
                            <input type="hidden" name="tutor_subdistrict" x-model="subdistrict">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Catatan <span class="text-gray-400 font-normal text-xs ml-1">(opsional)</span></label>
                            <textarea name="notes" rows="3" placeholder="Tambahkan catatan jika diperlukan..." 
                                      class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all resize-none"></textarea>
                        </div>

                        <button type="submit" :disabled="!isSubmitReady" class="w-full bg-gradient-to-r from-indigo-600 to-purple-700 text-white px-6 py-3.5 rounded-xl hover:shadow-lg hover:shadow-indigo-500/30 disabled:opacity-50 disabled:cursor-not-allowed font-bold flex justify-center items-center gap-2 transition-all">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Submit Absensi
                        </button>
                    </form>
                    @endif
                @else
                    <!-- Completed Attendance View -->
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-5">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="text-green-800 font-bold text-lg">Absensi Selesai</p>
                                <p class="text-sm text-green-600">Status: <span class="font-bold uppercase">{{ str_replace('_', ' ', $attendance->status) }}</span></p>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-4 border border-green-100 space-y-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Waktu Tercatat:</span>
                                <span class="font-semibold text-gray-800">{{ $attendance->captured_at ? $attendance->captured_at->format('d M Y, H:i') : '-' }}</span>
                            </div>
                            @if($attendance->tutor_subdistrict)
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-500">Lokasi Tutor:</span>
                                    <span class="font-semibold text-indigo-700 flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $attendance->tutor_subdistrict }}
                                    </span>
                                </div>
                            @endif
                            
                            @if($attendance->verification_status === 'manual_review')
                                <div class="flex items-center gap-2 text-sm text-amber-600 bg-amber-50 px-3 py-2 rounded-lg border border-amber-200">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    Menunggu Review Admin
                                </div>
                            @endif

                            @if($attendance->notes)
                                <div class="text-sm text-gray-600 pt-2 border-t border-gray-100">
                                    <span class="block text-xs font-semibold text-gray-400 mb-1">Catatan:</span>
                                    <p class="italic">"{{ $attendance->notes }}"</p>
                                </div>
                            @endif
                        </div>

                        @if($attendance->photo_path)
                            <div class="mt-4">
                                <p class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Bukti Kehadiran</p>
                                <img src="{{ Storage::url($attendance->photo_path) }}" alt="Bukti Hadir" class="w-full max-w-sm rounded-xl border-4 border-white shadow-md">
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Session Report Section -->
            @if($attendance && in_array($attendance->status, ['hadir', 'pindah_lokasi']))
                <div class="border-t pt-6 mt-6">
                    <h3 class="text-lg font-semibold mb-4">Laporan Sesi</h3>
                    @php
                        $report = $schedule->sessionReport;
                    @endphp
                    
                    @if(!$report)
                        <a href="{{ route('tutor.reports.create', $schedule) }}" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-all inline-flex items-center gap-2">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Buat Laporan Sesi
                        </a>
                    @else
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">Laporan Telah Disubmit</p>
                                    <p class="text-sm text-gray-500">Klien sudah dapat melihat perkembangan siswa.</p>
                                </div>
                            </div>
                            <a href="{{ route('tutor.reports.show', $report) }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-4 py-2 rounded-lg transition-colors">
                                Lihat Laporan
                            </a>
                        </div>

                        @if($report->parent_rating || $report->parent_feedback)
                            <div class="mt-4 p-4 bg-indigo-50 rounded-xl border border-indigo-100">
                                @if($report->parent_rating)
                                    <div class="mb-3">
                                        <label class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Rating dari Orang Tua</label>
                                        <div class="flex mt-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="h-5 w-5 {{ $i <= $report->parent_rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                @endif

                                @if($report->parent_feedback)
                                    <div>
                                        <label class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Feedback dari Orang Tua</label>
                                        <p class="mt-1 text-gray-700 italic text-sm">"{{ $report->parent_feedback }}"</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('attendanceForm', () => ({
        status: '',
        stream: null,
        photoCaptured: false,
        photoBase64: '',
        capturedAt: '',
        latitude: null,
        longitude: null,
        subdistrict: '',
        address: 'Mencari lokasi...',
        locationLoaded: false,

        get requiresPhoto() {
            return ['hadir', 'pindah_lokasi'].includes(this.status);
        },

        get isSubmitReady() {
            if (!this.status) return false;
            if (this.requiresPhoto && (!this.photoCaptured || !this.photoBase64)) return false;
            return true;
        },

        async handleStatusChange() {
            if (this.requiresPhoto) {
                this.photoCaptured = false;
                this.photoBase64 = '';
                this.capturedAt = '';
                this.latitude = null;
                this.longitude = null;
                this.address = 'Mencari lokasi...';
                this.locationLoaded = false;
                this.getLocation();
                await this.startCamera();
            } else {
                this.stopCamera();
            }
        },

        getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    async (pos) => {
                        this.latitude = pos.coords.latitude;
                        this.longitude = pos.coords.longitude;
                        await this.reverseGeocode(this.latitude, this.longitude);
                    },
                    (err) => {
                        console.warn("Location error:", err);
                        this.address = 'Izin Lokasi Ditolak';
                    },
                    { enableHighAccuracy: true, timeout: 8000 }
                );
            }
        },

        async reverseGeocode(lat, lon) {
            try {
                // zoom=14 untuk detail terbaik yang tersedia di OSM Indonesia
                const response = await fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=14&addressdetails=1`,
                    { headers: { 'Accept-Language': 'id', 'User-Agent': 'SistemBimbelMissi/1.0' } }
                );
                const data = await response.json();
                const addr = data.address;

                // Ambil data terbaik yang tersedia (kecamatan mungkin tidak ada di OSM rural)
                const kecamatan = addr.city_district || addr.subdistrict || addr.district || addr.municipality || '';
                const desa = addr.village || addr.suburb || addr.hamlet || '';
                const kabupaten = addr.county || addr.city || addr.regency || addr.state_district || '';

                if (kecamatan) {
                    // Kecamatan tersedia (biasanya kota besar)
                    this.subdistrict = `Kec. ${kecamatan}, ${kabupaten}`;
                    this.address = this.subdistrict;
                } else if (desa && kabupaten) {
                    // Kecamatan tidak ada di OSM, pakai Desa + Kabupaten
                    this.subdistrict = `${desa}, ${kabupaten}`;
                    this.address = this.subdistrict;
                } else {
                    // Fallback ke koordinat
                    this.address = `${lat.toFixed(5)}, ${lon.toFixed(5)}`;
                    this.subdistrict = this.address;
                }
            } catch (err) {
                console.error('Reverse geocoding error:', err);
                this.address = `${lat.toFixed(5)}, ${lon.toFixed(5)}`;
                this.subdistrict = this.address;
            } finally {
                this.locationLoaded = true;
            }
        },

        async startCamera() {
            this.stopCamera(); 
            try {
                this.stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { facingMode: 'environment' } 
                });
                this.$refs.video.srcObject = this.stream;
            } catch (err) {
                console.error("Camera access denied or error:", err);
                alert("Tidak dapat mengakses kamera. Pastikan Anda memberikan izin kamera pada browser.");
                this.status = ''; // Reset status jika kamera gagal
            }
        },

        stopCamera() {
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
                this.stream = null;
            }
        },

        capturePhoto() {
            if (!this.$refs.video.videoWidth) return;

            const video = this.$refs.video;
            const canvas = this.$refs.canvas;
            const ctx = canvas.getContext('2d');

            // --- AUTO RESIZE LOGIC ---
            // Maksimal dimensi agar ukuran file kecil (max ~150KB)
            const MAX_DIMENSION = 800; 
            let drawWidth = video.videoWidth;
            let drawHeight = video.videoHeight;

            if (drawWidth > drawHeight) {
                if (drawWidth > MAX_DIMENSION) {
                    drawHeight *= MAX_DIMENSION / drawWidth;
                    drawWidth = MAX_DIMENSION;
                }
            } else {
                if (drawHeight > MAX_DIMENSION) {
                    drawWidth *= MAX_DIMENSION / drawHeight;
                    drawHeight = MAX_DIMENSION;
                }
            }

            canvas.width = drawWidth;
            canvas.height = drawHeight;

            // Gambar frame video ke canvas dengan ukuran yang sudah di-resize
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Watermark Waktu, Status & Lokasi
            const now = new Date();
            const dateStr = now.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            const timestampText = `${dateStr} ${timeStr}`;
            const statusText = `STATUS: ${this.status.toUpperCase().replace('_', ' ')}`;
            const locationText = `LOC: ${this.address}`;

            // Background hitam transparan untuk teks
            ctx.fillStyle = 'rgba(0, 0, 0, 0.6)';
            
            // Responsif font dan background berdasarkan lebar canvas
            const scaleRatio = canvas.width / 800; // base ratio
            const bgHeight = 90 * scaleRatio;
            ctx.fillRect(0, canvas.height - bgHeight, canvas.width, bgHeight);

            // Teks watermark
            ctx.shadowColor = "rgba(0,0,0,0.5)";
            ctx.shadowBlur = 4 * scaleRatio;
            ctx.fillStyle = '#ffffff';
            
            // Baris 1: Waktu
            ctx.font = `bold ${Math.max(14, 24 * scaleRatio)}px sans-serif`;
            ctx.fillText(timestampText, 20 * scaleRatio, canvas.height - (65 * scaleRatio));
            
            // Baris 2: Status
            ctx.font = `bold ${Math.max(12, 18 * scaleRatio)}px sans-serif`;
            ctx.fillStyle = '#4ade80'; // Hijau
            ctx.fillText(statusText, 20 * scaleRatio, canvas.height - (40 * scaleRatio));
            
            // Baris 3: Lokasi (Alamat)
            ctx.font = `${Math.max(10, 16 * scaleRatio)}px sans-serif`;
            ctx.fillStyle = '#cbd5e1'; // Abu-abu terang
            ctx.fillText(locationText, 20 * scaleRatio, canvas.height - (15 * scaleRatio));

            // Konversi ke base64 (JPEG quality 70% untuk kompresi ekstra)
            this.photoBase64 = canvas.toDataURL('image/jpeg', 0.7);
            
            // Format ISO datetime untuk backend
            const y = now.getFullYear();
            const m = String(now.getMonth() + 1).padStart(2, '0');
            const d = String(now.getDate()).padStart(2, '0');
            const h = String(now.getHours()).padStart(2, '0');
            const min = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');
            
            this.capturedAt = `${y}-${m}-${d} ${h}:${min}:${s}`;
            this.photoCaptured = true;
            this.stopCamera();
        },

        retakePhoto() {
            this.photoCaptured = false;
            this.photoBase64 = '';
            this.capturedAt = '';
            this.startCamera();
        }
    }));
});
</script>
@endpush
@endsection
