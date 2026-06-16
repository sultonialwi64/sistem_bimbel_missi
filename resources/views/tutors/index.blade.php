@php
    $whatsappNumber = '62895392551182';
    $whatsappMessage = "Halo Admin Bimbel Missi, saya ingin bertanya dan berkonsultasi mengenai les privat.";
    $whatsappUrl = 'https://wa.me/' . $whatsappNumber . '?text=' . urlencode($whatsappMessage);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tutor | Bimbel Missi</title>
    <meta name="description" content="Daftar tutor aktif Bimbel Missi beserta bidang yang diampu.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        miss: {
                            navy: '#205085',
                            navyDark: '#173b63',
                            blueSoft: '#edf6fb',
                            gold: '#c28552',
                            goldDark: '#b46c43',
                            cream: '#fff8ed',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        * { letter-spacing: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .nav-glass {
            background: rgba(255, 255, 255, .9);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(226, 232, 240, .8);
        }
        .focus-ring:focus-visible {
            outline: 3px solid rgba(194, 133, 82, .38);
            outline-offset: 4px;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-white via-miss-cream to-miss-blueSoft text-slate-900 antialiased">
    <nav class="nav-glass sticky top-0 z-40">
        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="{{ url('/') }}" class="focus-ring flex items-center gap-3 rounded-lg" aria-label="Bimbel Missi">
                <img src="{{ asset('images/logo1.png') }}" alt="Logo Bimbel Missi" class="h-11 w-auto">
                <span class="hidden text-base font-black text-miss-navy sm:block">Missi Private Course</span>
            </a>
            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="focus-ring rounded-full px-4 py-2 text-sm font-extrabold text-miss-navy hover:bg-miss-blueSoft">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="focus-ring rounded-full px-4 py-2 text-sm font-extrabold text-miss-navy hover:bg-miss-blueSoft">Login Portal</a>
                    @endauth
                @endif
                <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring rounded-full bg-miss-gold px-5 py-3 text-sm font-black text-white shadow-lg transition hover:bg-miss-goldDark">
                    Konsultasi Gratis
                </a>
            </div>
        </div>
    </nav>

    <main class="px-4 py-10 sm:px-6 sm:py-14 lg:px-8 lg:py-16">
        <section class="mx-auto max-w-7xl">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <p class="text-xs font-black uppercase tracking-normal text-miss-goldDark">Daftar Tutor</p>
                    <h1 class="mt-3 text-3xl font-black leading-tight text-slate-950 sm:text-4xl lg:text-5xl">Tutor Aktif Bimbel Missi</h1>
                    <p class="mt-4 text-base leading-8 text-slate-600">Berikut beberapa tutor aktif yang siap disesuaikan dengan kebutuhan belajar, karakter anak, dan jadwal keluarga.</p>
                </div>
                <a href="{{ url('/#tutor') }}" class="focus-ring inline-flex rounded-full border border-slate-200 bg-white px-6 py-3 text-sm font-black text-miss-navy shadow-sm hover:bg-miss-blueSoft">
                    Kembali ke Beranda
                </a>
            </div>

            <div class="mt-8 rounded-lg border border-white/80 bg-white/80 p-5 shadow-lg shadow-slate-900/5 backdrop-blur-sm sm:p-6">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm font-bold text-slate-600">Menampilkan tutor aktif yang sudah siap dipublikasikan di landing page.</p>
                    <p class="text-sm font-black text-miss-navy">{{ $tutors->count() }} tutor aktif</p>
                </div>
            </div>

            <div class="mt-8 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                @forelse($tutors as $tutor)
                    @include('partials.public-tutor-card', ['tutor' => $tutor])
                @empty
                    <div class="rounded-lg border border-slate-200 bg-white p-8 text-center shadow-sm sm:col-span-2 xl:col-span-3">
                        <p class="text-lg font-black text-slate-900">Belum ada tutor aktif yang ditampilkan.</p>
                        <p class="mt-2 text-sm leading-7 text-slate-500">Data tutor akan muncul di sini setelah profil tutor aktif tersedia.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>
</body>
</html>
