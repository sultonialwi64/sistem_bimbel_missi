@extends('layouts.app')

@section('title', 'Payments')
@section('page-title', 'Payment Management')
@section('page-subtitle', 'Manage client payments')

@push('styles')
<style>
    [x-cloak] { display: none !important; }

    .payment-table th,
    .payment-table td {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }

    .payment-actions {
        display: flex;
        justify-content: flex-end;
        gap: 0.375rem;
        white-space: nowrap;
    }
</style>
@endpush

@section('content')
<div class="space-y-8" x-data="{ previewOpen: false, previewUrl: '', downloadUrl: '', previewTitle: '', waConfirmOpen: false, waConfirmAction: '', waConfirmTitle: '' }">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <p class="text-gray-500">Manage client payments & automated billing</p>
        </div>
    </div>

    <!-- Status Tabs -->
    <div class="flex items-center gap-3">
        <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}" class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ $statusFilter === 'all' ? 'bg-indigo-800 text-white shadow-md ring-2 ring-indigo-200' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200 shadow-sm' }}">
            Semua Tagihan
        </a>
        <a href="{{ request()->fullUrlWithQuery(['status' => 'unpaid']) }}" class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ $statusFilter === 'unpaid' ? 'bg-amber-500 text-white shadow-md ring-2 ring-amber-200' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200 shadow-sm' }}">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-white"></span>
                Belum Lunas
            </div>
        </a>
        <a href="{{ request()->fullUrlWithQuery(['status' => 'paid']) }}" class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all {{ $statusFilter === 'paid' ? 'bg-emerald-500 text-white shadow-md ring-2 ring-emerald-200' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200 shadow-sm' }}">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-white"></span>
                Lunas
            </div>
        </a>
    </div>

    <!-- Search Bar -->
    <form action="{{ route('admin.payments.index') }}" method="GET">
        <div class="flex items-center gap-3">
            <div class="relative flex-1">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama client, siswa, atau tutor..." class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 bg-white text-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 shadow-sm transition-all">
            </div>
            <button type="submit" class="px-6 py-3 bg-indigo-800 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all shadow-sm">Cari</button>
            @if(request('search'))
                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="px-4 py-3 bg-white text-slate-600 border border-slate-200 rounded-xl text-sm font-bold hover:bg-slate-50 transition-all shadow-sm">Clear</a>
            @endif
            <input type="hidden" name="filter_month" value="{{ request('filter_month') }}">
            <input type="hidden" name="status" value="{{ request('status', 'all') }}">
        </div>
    </form>

    <div class="card-premium overflow-hidden">
        <div class="bg-indigo-800 px-6 py-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zm11 0a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                    Daftar Tagihan
                </h3>
                
                <div class="flex items-center gap-4 w-full sm:w-auto">
                    <!-- Filter Form -->
                    <form action="{{ route('admin.payments.index') }}" method="GET" class="flex items-center gap-2">
                        <input type="month" name="filter_month" value="{{ request('filter_month') }}" class="rounded-xl border-none bg-indigo-900 text-white text-sm focus:ring-2 focus:ring-blue-400 py-1.5 px-3">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1.5 rounded-xl text-sm font-bold transition-colors">
                            Filter
                        </button>
                        @if(request()->has('filter_month'))
                            <a href="{{ route('admin.payments.index') }}" class="text-indigo-200 hover:text-white text-xs font-bold underline">Clear</a>
                        @endif
                    </form>
                    <span class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-500/15 px-3 py-1.5 text-xs font-bold text-emerald-100 ring-1 ring-emerald-300/20">
                        <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                        Auto Sync
                    </span>
                    <span class="text-indigo-200 text-sm font-semibold hidden sm:inline-block">Total: {{ $payments->total() }}</span>
                </div>
            </div>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="table-premium payment-table min-w-[1160px] table-fixed">
                <colgroup>
                    <col class="w-[22%]">
                    <col class="w-[10%]">
                    <col class="w-[9%]">
                    <col class="w-[8%]">
                    <col class="w-[7%]">
                    <col class="w-[10%]">
                    <col class="w-[8%]">
                    <col class="w-[7%]">
                    <col class="w-[19%]">
                </colgroup>
                <thead>
                    <tr>
                        <th class="text-left py-4 px-6">Klien</th>
                        <th class="text-left py-4 px-6">Siswa</th>
                        <th class="text-left py-4 px-6">Tentor</th>
                        <th class="text-left py-4 px-6">Periode</th>
                        <th class="text-left py-4 px-6">Diskon</th>
                        <th class="text-left py-4 px-6">Tagihan</th>
                        <th class="text-left py-4 px-6">Tanggal Bayar</th>
                        <th class="text-left py-4 px-6">Status</th>
                        <th class="text-right py-4 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr class="group">
                            <td class="py-4 px-6">
                                <div class="flex min-w-0 items-center gap-3">
                                    <div class="h-10 w-10 rounded-xl bg-indigo-700 flex items-center justify-center shadow-lg flex-shrink-0">
                                        <span class="text-white font-bold text-xs">{{ substr($payment->client->user->name, 0, 2) }}</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-bold text-gray-900 group-hover:text-purple-600 transition-colors flex items-center gap-1.5 min-w-0">
                                            <span class="truncate">{{ $payment->client->user->name }}</span>
                                            <span class="inline-flex items-center justify-center h-4 w-4 rounded-full text-[9px] font-black {{ $payment->client->client_type === 'tipe_1' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700' }}">{{ $payment->client->client_type === 'tipe_1' ? '1' : '2' }}</span>
                                        </p>
                                        <p class="text-xs text-gray-500 truncate">{{ $payment->client->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-medium text-gray-900 break-words">{{ $payment->student->name }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm text-gray-700 break-words">{{ $payment->tutor_names ?: '-' }}</p>
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $periodMonth = \Carbon\Carbon::parse($payment->due_date)->subDays(7)->startOfMonth();
                                @endphp
                                <div>
                                    <p class="text-sm font-bold text-gray-800">{{ $periodMonth->translatedFormat('F Y') }}</p>
                                    <p class="text-xs text-gray-400">{{ $periodMonth->format('01 M') }} – {{ $periodMonth->endOfMonth()->format('d M Y') }}</p>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @if($payment->discount > 0)
                                    @php $countAnak = $clientDiscountCounts[$payment->client_id] ?? 0; @endphp
                                    <div>
                                        <p class="text-sm font-semibold text-red-600">- Rp {{ number_format($payment->discount, 0, ',', '.') }}</p>
                                        @if($countAnak > 0)
                                            <p class="text-[10px] text-gray-400 leading-tight">{{ $countAnak }} anak</p>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-sm text-gray-400">-</p>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-lg font-black text-gray-900 whitespace-nowrap">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            </td>
                            <td class="py-4 px-6">
                                @if($payment->payment_date)
                                    <p class="text-sm font-bold text-emerald-700">{{ $payment->payment_date->format('d M Y') }}</p>
                                    <p class="text-xs text-gray-400">{{ $payment->payment_date->format('H:i') }} WIB</p>
                                @else
                                    <p class="text-sm text-gray-400">-</p>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold
                                    @if($payment->status === 'paid') bg-gradient-to-r from-green-50 to-emerald-50 text-green-700 border border-green-200
                                    @elseif($payment->status === 'pending') bg-gradient-to-r from-amber-50 to-orange-50 text-amber-700 border border-amber-200
                                    @elseif($payment->status === 'overdue') bg-gradient-to-r from-red-50 to-pink-50 text-red-700 border border-red-200
                                    @else bg-gradient-to-r from-gray-50 to-gray-100 text-gray-700 border border-gray-200
                                    @endif">
                                    {{ ucfirst($payment->status) }}
                                </span>
                                <div class="mt-2">
                                    @if($payment->wa_sent_at)
                                        <span class="inline-flex items-center rounded-full border border-blue-200 bg-blue-50 px-2.5 py-1 text-[10px] font-bold text-blue-700" title="Ditandai oleh {{ $payment->waSentBy->name ?? 'Admin' }}">
                                            WA {{ $payment->wa_sent_at->format('d M H:i') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-[10px] font-bold text-slate-500">
                                            Belum WA
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="payment-actions-cell py-4 px-6 text-right">
                                @php
                                    $dlMonth = $periodMonth->format('Y-m');
                                    $dlLink = URL::signedRoute('public.report.download', ['student' => $payment->student_id, 'month' => $dlMonth]);
                                    $previewLink = URL::signedRoute('public.report.download', ['student' => $payment->student_id, 'month' => $dlMonth, 'preview' => 1]);
                                @endphp
                                <div class="payment-actions">
                                    <button type="button" @click="previewOpen = true; previewUrl = @js($previewLink); downloadUrl = @js($dlLink); previewTitle = @js('Laporan ' . $payment->student->name . ' - ' . \Carbon\Carbon::parse($dlMonth)->translatedFormat('F Y'))" class="inline-flex items-center gap-1.5 px-2.5 py-2 bg-white text-gray-700 border border-gray-200 rounded-xl font-bold text-xs hover:bg-gray-50 hover:border-gray-300 transition-all" title="Preview Laporan PDF">
                                        <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        PDF
                                    </button>
                                    @if($payment->status !== 'paid' && $payment->client->user->phone)
                                        @php
                                            $waNumber     = preg_replace('/[^0-9]/', '', $payment->client->user->phone);
                                            if (!str_starts_with($waNumber, '62')) {
                                                $waNumber = '62' . ltrim($waNumber, '0');
                                            }
                                            $studentName = $payment->student->name;
                                            $clientName  = $payment->client->user->name;
                                            $bulan       = \Carbon\Carbon::parse($dlMonth)->translatedFormat('F Y');
                                            $tagihan     = 'Rp ' . number_format($payment->amount, 0, ',', '.');

                                            $waText  = "Halo Bapak/Ibu *{$clientName}*,\n\n";
                                            $waText .= "Berikut adalah rekap laporan belajar ananda *{$studentName}* selama bulan *{$bulan}*.\n\n";
                                            $waText .= "📄 *Laporan Belajar (PDF):*\n";
                                            $waText .= $dlLink . "\n\n";
                                            $waText .= "_(Klik link di atas untuk membuka & mengunduh laporan. Tidak perlu login)_\n\n";
                                            $waText .= "Bersamaan dengan ini, kami informasikan total tagihan biaya bimbingan belajar bulan ini adalah sebesar *{$tagihan}*.\n\n";
                                            $waText .= "Mohon berkenan untuk melakukan pembayaran melalui rekening:\n";
                                            $waText .= "*Bank BRI*\n";
                                            $waText .= "*No. Rekening: 011201074931505*\n";
                                            $waText .= "*Atas Nama: Ike Indah Pratiwi*\n\n";
                                            $waText .= "Jika sudah melakukan transfer, silakan balas pesan ini beserta foto bukti transfernya ya.\n\n";
                                            $waText .= "Terima kasih banyak! 🙏";
                                            $waUrl = "https://wa.me/" . $waNumber . "?text=" . urlencode($waText);
                                        @endphp
                                        <a href="{{ $waUrl }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-2 bg-green-600 text-white border border-green-700 rounded-xl font-bold text-xs hover:bg-green-700 shadow-sm hover:shadow-md transition-all" title="Kirim Tagihan & Rapor via WA">
                                            <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.441-1.273.606-1.446c.163-.173.353-.217.473-.217l.361.002c.118.002.277-.044.433.33.161.385.55 1.341.599 1.442.049.101.082.218.01.389-.071.171-.108.277-.215.398-.109.122-.23.267-.327.369-.108.114-.222.24-.097.455.124.216.55 0.912 1.178 1.472.812.723 1.498.948 1.708 1.054.21.106.331.088.455-.052.124-.14 0.536-.622.682-.835.145-.213.291-.177.485-.104.195.072 1.229.58 1.439.685.21.105.351.157.402.244.051.087.051.503-.093.908z" /></svg>
                                            WA
                                        </a>
                                    @endif
                                    @unless($payment->wa_sent_at)
                                        <button type="button" @click="waConfirmOpen = true; waConfirmAction = @js(route('admin.payments.mark-wa-sent', $payment)); waConfirmTitle = @js($payment->client->user->name . ' - ' . $payment->student->name)" class="inline-flex items-center justify-center px-2.5 py-2 bg-blue-50 text-blue-700 border border-blue-100 rounded-xl font-bold text-xs hover:bg-blue-100 transition-all" title="Tandai sudah dikirim via WhatsApp">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    @endunless
                                    <a href="{{ route('admin.payments.show', $payment) }}" class="inline-flex items-center gap-1.5 px-2.5 py-2 bg-slate-50 text-indigo-700 border border-indigo-100 rounded-xl font-bold text-xs hover:bg-indigo-50 transition-all">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="h-20 w-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zm11 0a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                                    </div>
                                    <p class="text-gray-500 font-semibold">Belum ada data tagihan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Card List --}}
        <div class="sm:hidden p-4 space-y-3">
            @forelse($payments as $payment)
                @php
                    $periodMonth = \Carbon\Carbon::parse($payment->due_date)->subDays(7)->startOfMonth();
                @endphp
                <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm">
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="h-9 w-9 rounded-xl bg-indigo-700 flex items-center justify-center shadow-md flex-shrink-0">
                                <span class="text-white font-bold text-xs">{{ substr($payment->client->user->name, 0, 2) }}</span>
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-gray-900 text-sm truncate flex items-center gap-1.5">
                                    {{ $payment->client->user->name }}
                                    <span class="inline-flex items-center justify-center h-4 w-4 rounded-full text-[9px] font-black flex-shrink-0 {{ $payment->client->client_type === 'tipe_1' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700' }}">{{ $payment->client->client_type === 'tipe_1' ? '1' : '2' }}</span>
                                </p>
                                <p class="text-xs text-gray-500 truncate">Siswa: {{ $payment->student->name }}</p>
                                <p class="text-xs text-gray-400 truncate">Tentor: {{ $payment->tutor_names ?: '-' }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-1 flex-shrink-0">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold
                                @if($payment->status === 'paid') bg-green-100 text-green-700
                                @elseif($payment->status === 'pending') bg-amber-100 text-amber-700
                                @elseif($payment->status === 'overdue') bg-red-100 text-red-700
                                @else bg-gray-100 text-gray-700
                                @endif">
                                {{ ucfirst($payment->status) }}
                            </span>
                            @if($payment->wa_sent_at)
                                <span class="inline-flex items-center rounded-full bg-blue-50 px-2 py-0.5 text-[9px] font-bold text-blue-700">
                                    WA {{ $payment->wa_sent_at->format('d M H:i') }}
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-slate-50 px-2 py-0.5 text-[9px] font-bold text-slate-500">
                                    Belum WA
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center justify-between py-2 border-y border-gray-50 mb-3">
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold">Periode</p>
                            <p class="text-xs font-semibold text-gray-700">{{ $periodMonth->translatedFormat('F Y') }}</p>
                        </div>
                        @if($payment->discount > 0)
                        <div class="text-center">
                            <p class="text-[10px] text-gray-400 uppercase font-bold">Diskon</p>
                            <p class="text-xs font-bold text-red-600">- Rp {{ number_format($payment->discount, 0, ',', '.') }}</p>
                            @php $countAnak = $clientDiscountCounts[$payment->client_id] ?? 0; @endphp
                            @if($countAnak > 0)
                                <p class="text-[9px] text-gray-400">{{ $countAnak }} anak</p>
                            @endif
                        </div>
                        @endif
                        <div class="text-right">
                            <p class="text-[10px] text-gray-400 uppercase font-bold">Tagihan</p>
                            <p class="text-base font-black text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                        </div>
                        @if($payment->payment_date)
                            <div class="text-right">
                                <p class="text-[10px] text-gray-400 uppercase font-bold">Tgl Bayar</p>
                                <p class="text-xs font-semibold text-emerald-700">{{ $payment->payment_date->format('d M Y') }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        @php
                            $dlMonth = $periodMonth->format('Y-m');
                            $dlLink = URL::signedRoute('public.report.download', ['student' => $payment->student_id, 'month' => $dlMonth]);
                            $previewLink = URL::signedRoute('public.report.download', ['student' => $payment->student_id, 'month' => $dlMonth, 'preview' => 1]);
                        @endphp
                        <button type="button" @click="previewOpen = true; previewUrl = @js($previewLink); downloadUrl = @js($dlLink); previewTitle = @js('Laporan ' . $payment->student->name . ' - ' . \Carbon\Carbon::parse($dlMonth)->translatedFormat('F Y'))" class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 bg-white text-gray-700 border border-gray-200 rounded-xl font-bold text-xs hover:bg-gray-50 transition-all">
                            <svg class="h-3.5 w-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            PDF
                        </button>
                        @if($payment->status !== 'paid' && $payment->client->user->phone)
                            @php
                                $waNumber     = preg_replace('/[^0-9]/', '', $payment->client->user->phone);
                                if (!str_starts_with($waNumber, '62')) {
                                    $waNumber = '62' . ltrim($waNumber, '0');
                                }
                                $studentName = $payment->student->name;
                                $clientName  = $payment->client->user->name;
                                $bulan       = \Carbon\Carbon::parse($dlMonth)->translatedFormat('F Y');
                                $tagihan     = 'Rp ' . number_format($payment->amount, 0, ',', '.');
                                $waText  = "Halo Bapak/Ibu *{$clientName}*,\n\nBerikut adalah rekap laporan belajar ananda *{$studentName}* selama bulan *{$bulan}*.\n\n📄 *Laporan Belajar (PDF):*\n{$dlLink}\n\n_(Klik link di atas untuk membuka & mengunduh laporan)_\n\nTagihan bulan ini: *{$tagihan}*.\nMohon pembayaran melalui rekening:\n*Bank BRI*\n*No. Rekening: 011201074931505*\n*Atas Nama: Ike Indah Pratiwi*\n\nTerima kasih! 🙏";
                                $waUrl = "https://wa.me/" . $waNumber . "?text=" . urlencode($waText);
                            @endphp
                            <a href="{{ $waUrl }}" target="_blank" class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 bg-green-600 text-white rounded-xl font-bold text-xs hover:bg-green-700 transition-all">
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771z"/></svg>
                                WhatsApp
                            </a>
                        @endif
                        @unless($payment->wa_sent_at)
                            <button type="button" @click="waConfirmOpen = true; waConfirmAction = @js(route('admin.payments.mark-wa-sent', $payment)); waConfirmTitle = @js($payment->client->user->name . ' - ' . $payment->student->name)" class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 bg-blue-50 text-blue-700 rounded-xl font-bold text-xs hover:bg-blue-100 transition-all">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Tandai
                            </button>
                        @endunless
                        <a href="{{ route('admin.payments.show', $payment) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 bg-indigo-50 text-indigo-700 rounded-xl font-semibold text-xs hover:bg-indigo-100 transition-all">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-gray-500 font-semibold">Belum ada data tagihan</p>
                </div>
            @endforelse
        </div>

        @if($payments->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $payments->links() }}
            </div>
        @endif
    </div>

    <div
        x-cloak
        x-show="previewOpen"
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 px-4 py-6"
        @keydown.escape.window="previewOpen = false; previewUrl = ''"
    >
        <div class="absolute inset-0" @click="previewOpen = false; previewUrl = ''"></div>
        <div class="relative flex h-[88vh] w-full max-w-6xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl">
            <div class="flex items-center justify-between gap-4 border-b border-slate-200 px-5 py-3">
                <div class="min-w-0">
                    <h3 class="truncate text-base font-black text-slate-900" x-text="previewTitle || 'Preview Laporan PDF'"></h3>
                    <p class="text-xs font-semibold text-slate-500">Preview laporan sebelum dikirim atau diunduh</p>
                </div>
                <div class="flex items-center gap-2">
                    <a :href="downloadUrl" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-700 shadow-sm transition-all hover:bg-slate-50">
                        <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Download
                    </a>
                    <button type="button" @click="previewOpen = false; previewUrl = ''" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 shadow-sm transition-all hover:bg-slate-50 hover:text-slate-800" title="Tutup preview">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            <div class="min-h-0 flex-1 bg-slate-100">
                <iframe x-show="previewUrl" :src="previewUrl" class="h-full w-full border-0 bg-white"></iframe>
            </div>
        </div>
    </div>

    <div
        x-cloak
        x-show="waConfirmOpen"
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 px-4 py-6"
        @keydown.escape.window="waConfirmOpen = false"
    >
        <div class="absolute inset-0" @click="waConfirmOpen = false"></div>
        <div class="relative w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">
            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex items-start gap-4">
                    <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-lg font-black text-slate-900">Tandai Sudah Dikirim?</h3>
                        <p class="mt-1 text-sm leading-6 text-slate-500">
                            Tagihan <span class="font-bold text-slate-700" x-text="waConfirmTitle"></span> akan ditandai sudah dikirim via WhatsApp.
                        </p>
                    </div>
                </div>
            </div>
            <form :action="waConfirmAction" method="POST" class="flex items-center justify-end gap-3 bg-slate-50 px-6 py-4">
                @csrf
                <button type="button" @click="waConfirmOpen = false" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-600 shadow-sm transition-all hover:bg-slate-100">
                    Batal
                </button>
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition-all hover:bg-blue-800">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Tandai
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
