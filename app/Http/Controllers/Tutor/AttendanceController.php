<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\{Schedule, Attendance};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Submit attendance for a schedule (Photo + Status)
     */
    public function submitAttendance(Request $request, Schedule $schedule)
    {
        // Authorize
        $tutor = Auth::user()->tutor;
        if (!$tutor || $schedule->tutor_id != $tutor->id) {
            abort(403, 'Unauthorized access: Jadwal ini bukan milik Anda.');
        }

        // === VALIDASI WAKTU ABSEN ===
        $scheduleDate  = $schedule->date->format('Y-m-d');
        // Selalu pakai tanggal dari $schedule->date, ambil hanya H:i:s dari start_time/end_time
        $sessionStart  = \Carbon\Carbon::parse($scheduleDate . ' ' . \Carbon\Carbon::parse($schedule->start_time)->format('H:i:s'));
        $sessionEnd    = \Carbon\Carbon::parse($scheduleDate . ' ' . \Carbon\Carbon::parse($schedule->end_time)->format('H:i:s'));
        $deadlineAbsen = $sessionEnd->copy()->addMinutes(90);
        $now = now();

        if ($now->lt($sessionStart)) {
            return back()->with('error', 'Absensi belum bisa dilakukan. Sesi dimulai pukul ' . $sessionStart->format('H:i') . ' WIB.');
        }

        if ($now->gt($deadlineAbsen)) {
            return back()->with('error', 'Waktu absensi sudah habis. Batas terakhir adalah ' . $deadlineAbsen->format('H:i') . ' WIB (90 menit setelah sesi selesai).');
        }

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:hadir,libur_sakit,pindah_lokasi,batal'],
            'photo_base64' => ['nullable', 'string'],
            'captured_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:500'],
            'tutor_lat' => ['nullable', 'numeric'],
            'tutor_lng' => ['nullable', 'numeric'],
            'tutor_subdistrict' => ['nullable', 'string', 'max:255'],
        ]);

        $status = $validated['status'];
        $requiresPhoto = in_array($status, ['hadir', 'pindah_lokasi']);

        if ($requiresPhoto) {
            if (empty($validated['photo_base64']) || empty($validated['captured_at'])) {
                return back()->with('error', 'Foto dan waktu pengambilan (captured_at) wajib ada untuk status ini.');
            }

            // Server-side validation: max 2 menit dari waktu saat ini
            $capturedAt = Carbon::parse($validated['captured_at']);
            $diffInMinutes = $capturedAt->diffInMinutes(now());
            
            $verificationStatus = 'verified';
            if ($diffInMinutes > 2) {
                $verificationStatus = 'manual_review';
            }

            // Handle base64 decode
            $photoPath = null;
            if (preg_match('/^data:image\/(\w+);base64,/', $validated['photo_base64'], $type)) {
                $data = substr($validated['photo_base64'], strpos($validated['photo_base64'], ',') + 1);
                $type = strtolower($type[1]); // jpg, png, dll

                if (!in_array($type, ['jpg', 'jpeg', 'png', 'webp'])) {
                    return back()->with('error', 'Format gambar tidak valid.');
                }

                $data = base64_decode($data);
                if ($data === false) {
                    return back()->with('error', 'Gagal memproses gambar foto.');
                }

                // Generate nama file unik
                $fileName = now()->format('Ymd_His') . '_' . uniqid() . '.' . $type;
                $photoPath = 'attendances/' . $fileName;

                // Simpan ke storage (storage/app/public/attendances)
                Storage::disk('public')->put($photoPath, $data);
            } else {
                return back()->with('error', 'Data foto rusak atau tidak valid.');
            }

            // Create/Update Attendance
            Attendance::updateOrCreate(
                ['schedule_id' => $schedule->id],
                [
                    'tutor_id' => $schedule->tutor_id,
                    'status' => $status,
                    'photo_path' => $photoPath,
                    'captured_at' => $capturedAt,
                    'verification_status' => $verificationStatus,
                    'notes' => $validated['notes'] ?? null,
                    'tutor_lat' => $validated['tutor_lat'] ?? null,
                    'tutor_lng' => $validated['tutor_lng'] ?? null,
                    'tutor_subdistrict' => $validated['tutor_subdistrict'] ?? null,
                ]
            );

            // Update status schedule
            $schedule->update(['status' => 'completed']);

            $msg = 'Absensi berhasil disubmit.';
            if ($verificationStatus === 'manual_review') {
                $msg .= ' (Waktu melebihi batas, perlu Review Admin)';
            }
            
            return redirect()->route('tutor.schedules.show', $schedule)->with('success', $msg);

        } else {
            // Status libur_sakit atau batal -> skip foto
            Attendance::updateOrCreate(
                ['schedule_id' => $schedule->id],
                [
                    'tutor_id' => $schedule->tutor_id,
                    'status' => $status,
                    'photo_path' => null,
                    'captured_at' => now(), // catat waktu submit
                    'verification_status' => 'verified',
                    'notes' => $validated['notes'] ?? null,
                ]
            );

            if ($status === 'batal') {
                $schedule->update(['status' => 'cancelled']);
            } else {
                // libur_sakit
                $schedule->update(['status' => 'completed']);
            }

            return redirect()->route('tutor.schedules.show', $schedule)
                ->with('success', 'Status jadwal berhasil diperbarui menjadi: ' . str_replace('_', ' ', $status));
        }
    }
}
