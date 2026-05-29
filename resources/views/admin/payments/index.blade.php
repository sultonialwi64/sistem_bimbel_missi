@extends('layouts.app')

@section('title', 'Payments')
@section('page-title', 'Payment Management')
@section('page-subtitle', 'Manage client payments')

@section('content')
<div class="space-y-8">
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
                    <span class="text-indigo-200 text-sm font-semibold hidden sm:inline-block">Total: {{ $payments->total() }}</span>
                </div>
            </div>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th class="text-left py-4 px-6">Klien</th>
                        <th class="text-left py-4 px-6">Siswa</th>
                        <th class="text-left py-4 px-6">Periode</th>
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
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-xl bg-indigo-700 flex items-center justify-center shadow-lg">
                                        <span class="text-white font-bold text-xs">{{ substr($payment->client->user->name, 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 group-hover:text-purple-600 transition-colors">{{ $payment->client->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $payment->client->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-medium text-gray-900">{{ $payment->student->name }}</p>
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
                                <p class="text-lg font-black text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
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
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($payment->status !== 'paid' && $payment->client->user->phone)
                                        @php
                                            $month        = $periodMonth->format('Y-m');
                                            $downloadLink = URL::signedRoute('public.report.download', ['student' => $payment->student_id, 'month' => $month]);
                                            $waNumber     = preg_replace('/[^0-9]/', '', $payment->client->user->phone);
                                            if (!str_starts_with($waNumber, '62')) {
                                                $waNumber = '62' . ltrim($waNumber, '0');
                                            }
                                            $studentName = $payment->student->name;
                                            $clientName  = $payment->client->user->name;
                                            $bulan       = \Carbon\Carbon::parse($month)->translatedFormat('F Y');
                                            $tagihan     = 'Rp ' . number_format($payment->amount, 0, ',', '.');

                                            $waText  = "Halo Bapak/Ibu *{$clientName}*,\n\n";
                                            $waText .= "Berikut adalah rekap laporan belajar ananda *{$studentName}* selama bulan *{$bulan}*.\n\n";
                                            $waText .= "📄 *Laporan Belajar (PDF):*\n";
                                            $waText .= $downloadLink . "\n\n";
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
                                        <a href="{{ $waUrl }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-600 text-white border border-green-700 rounded-xl font-bold text-xs hover:bg-green-700 shadow-sm hover:shadow-md transition-all" title="Kirim Tagihan & Rapor via WA">
                                            <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.441-1.273.606-1.446c.163-.173.353-.217.473-.217l.361.002c.118.002.277-.044.433.33.161.385.55 1.341.599 1.442.049.101.082.218.01.389-.071.171-.108.277-.215.398-.109.122-.23.267-.327.369-.108.114-.222.24-.097.455.124.216.55 0.912 1.178 1.472.812.723 1.498.948 1.708 1.054.21.106.331.088.455-.052.124-.14 0.536-.622.682-.835.145-.213.291-.177.485-.104.195.072 1.229.58 1.439.685.21.105.351.157.402.244.051.087.051.503-.093.908z" /></svg>
                                            WA
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.payments.show', $payment) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-50 text-indigo-700 border border-indigo-100 rounded-xl font-semibold text-sm hover:bg-indigo-50 transition-all">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
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
                                <p class="font-bold text-gray-900 text-sm truncate">{{ $payment->client->user->name }}</p>
                                <p class="text-xs text-gray-500 truncate">Siswa: {{ $payment->student->name }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold flex-shrink-0
                            @if($payment->status === 'paid') bg-green-100 text-green-700
                            @elseif($payment->status === 'pending') bg-amber-100 text-amber-700
                            @elseif($payment->status === 'overdue') bg-red-100 text-red-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-y border-gray-50 mb-3">
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold">Periode</p>
                            <p class="text-xs font-semibold text-gray-700">{{ $periodMonth->translatedFormat('F Y') }}</p>
                        </div>
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
                        @if($payment->status !== 'paid' && $payment->client->user->phone)
                            @php
                                $month        = $periodMonth->format('Y-m');
                                $downloadLink = URL::signedRoute('public.report.download', ['student' => $payment->student_id, 'month' => $month]);
                                $waNumber     = preg_replace('/[^0-9]/', '', $payment->client->user->phone);
                                if (!str_starts_with($waNumber, '62')) {
                                    $waNumber = '62' . ltrim($waNumber, '0');
                                }
                                $studentName = $payment->student->name;
                                $clientName  = $payment->client->user->name;
                                $bulan       = \Carbon\Carbon::parse($month)->translatedFormat('F Y');
                                $tagihan     = 'Rp ' . number_format($payment->amount, 0, ',', '.');
                                $waText  = "Halo Bapak/Ibu *{$clientName}*,\n\nBerikut adalah rekap laporan belajar ananda *{$studentName}* selama bulan *{$bulan}*.\n\n📄 *Laporan Belajar (PDF):*\n{$downloadLink}\n\n_(Klik link di atas untuk membuka & mengunduh laporan)_\n\nTagihan bulan ini: *{$tagihan}*.\nMohon pembayaran melalui rekening:\n*Bank BRI*\n*No. Rekening: 011201074931505*\n*Atas Nama: Ike Indah Pratiwi*\n\nTerima kasih! 🙏";
                                $waUrl = "https://wa.me/" . $waNumber . "?text=" . urlencode($waText);
                            @endphp
                            <a href="{{ $waUrl }}" target="_blank" class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 bg-green-600 text-white rounded-xl font-bold text-xs hover:bg-green-700 transition-all">
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771z"/></svg>
                                WhatsApp
                            </a>
                        @endif
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
</div>
@endsection
