@php
    $whatsappNumber = '62895392551182';
    $whatsappMessage = "Halo Admin Bimbel Missi, saya ingin bertanya dan berkonsultasi mengenai les privat.";
    $whatsappUrl = 'https://wa.me/' . $whatsappNumber . '?text=' . urlencode($whatsappMessage);
@endphp
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tutor | Bimbel Missi</title>
    <meta name="description" content="Daftar tutor aktif Bimbel Missi beserta bidang yang diampu.">
    
    <link rel="icon" href="{{ asset('images/logo.png') }}?v=3" type="image/png">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@600;700;800;900&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                        mono: ['Space Grotesk', 'monospace'],
                    },
                    colors: {
                        'electric-blue': '#2563eb',
                        'acid-lime': '#d9f99d',
                        'vivid-amber': '#fbbf24',
                        'neon-pink': '#f43f5e',
                        'dark-ink': '#0f172a',
                        'retro-cream': '#fffbeb',
                    }
                }
            }
        }
    </script>
    
    <style>
        * { letter-spacing: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .brutal-shadow { box-shadow: 4px 4px 0px #0f172a; }
        .brutal-shadow-hover { transition: all 0.15s ease-in-out; }
        .brutal-shadow-hover:hover { transform: translate(2px, 2px); box-shadow: 2px 2px 0px #0f172a; }
        
        .nav-glass {
            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 2px solid #0f172a;
        }

        .focus-ring:focus-visible { outline: 3px solid rgba(37, 99, 235, .4); outline-offset: 4px; }
        .bg-grid-pattern {
            background-image:
                linear-gradient(to right, rgba(15, 23, 42, 0.07) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(15, 23, 42, 0.07) 1px, transparent 1px);
            background-size: 28px 28px;
        }
    </style>
</head>
<body class="bg-white text-slate-900 antialiased overflow-x-hidden">
    <nav class="nav-glass sticky top-0 z-40">
        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="{{ url('/') }}" class="focus-ring flex items-center gap-3 rounded-lg" aria-label="Bimbel Missi">
                <img src="{{ asset('images/logo1.png') }}" alt="Logo Bimbel Missi" class="h-12 w-12 rounded-full border-[2px] border-dark-ink object-cover transition-transform hover:scale-105">
                <span class="text-sm font-black text-dark-ink sm:text-base font-display">Missi Private Course</span>
            </a>
            
            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="focus-ring rounded-xl px-4 py-2 text-sm font-black text-dark-ink hover:text-electric-blue font-mono uppercase tracking-widest">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="focus-ring rounded-xl px-4 py-2 text-sm font-black text-dark-ink hover:text-electric-blue font-mono uppercase tracking-widest hidden sm:block">Login</a>
                    @endauth
                @endif
                <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring inline-flex rounded-xl border-2 border-dark-ink bg-electric-blue px-5 py-2.5 text-sm font-black text-white brutal-shadow brutal-shadow-hover transition hover:bg-dark-ink hidden sm:inline-flex">
                    Konsultasi Gratis
                </a>
            </div>
        </div>
    </nav>

    <main class="bg-grid-pattern min-h-screen border-b-4 border-dark-ink pb-20 pt-10 sm:pt-16">
        <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <p class="inline-block bg-vivid-amber px-2 py-1 text-xs font-black uppercase tracking-widest text-dark-ink font-mono border-2 border-dark-ink shadow-[2px_2px_0px_#0f172a]">Katalog Tutor</p>
                    <h1 class="mt-5 text-4xl font-black leading-tight text-slate-950 sm:text-5xl lg:text-6xl font-display tracking-tight">Temukan Tutor yang Tepat</h1>
                    <p class="mt-6 text-lg leading-8 text-slate-800 font-bold bg-white/80 p-4 rounded-xl border-2 border-dark-ink">Berikut tutor aktif yang siap mendampingi proses belajar anak dengan jadwal yang fleksibel.</p>
                </div>
                
                <div class="flex flex-col gap-3 sm:flex-row mt-6 lg:mt-0">
                    <a href="{{ url('/#tutor') }}" class="focus-ring inline-flex items-center justify-center rounded-xl border-2 border-dark-ink bg-white px-6 py-3 text-sm font-black text-electric-blue brutal-shadow brutal-shadow-hover transition hover:bg-retro-cream">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>

            <div class="mt-12 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between rounded-xl border-4 border-dark-ink bg-white px-5 py-4 brutal-shadow">
                <div>
                    <p class="text-sm font-black text-electric-blue">Katalog Publik</p>
                    <p class="mt-1 text-xs font-bold leading-6 text-slate-500">Menampilkan profil tutor yang siap mengajar.</p>
                </div>
                <div class="inline-flex rounded-lg border-2 border-dark-ink bg-acid-lime px-4 py-2 font-black text-dark-ink brutal-shadow-sm font-mono text-sm">
                    {{ $tutors->count() }} Tutor Aktif
                </div>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse($tutors as $tutor)
                    @include('partials.public-tutor-card', ['tutor' => $tutor])
                @empty
                    <div class="col-span-full rounded-2xl border-4 border-dark-ink bg-white p-12 text-center brutal-shadow">
                        <p class="text-2xl font-black text-slate-900 font-display">Belum ada tutor aktif</p>
                        <p class="mt-4 text-base font-bold text-slate-600">Data tutor akan muncul di sini setelah profil tutor diverifikasi dan diaktifkan.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <footer class="border-t-4 border-dark-ink bg-dark-ink py-10 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-col items-center justify-center text-center">
            <p class="font-display font-black text-2xl tracking-widest text-acid-lime">MISSI PRIVATE COURSE</p>
            <p class="mt-4 text-sm font-bold text-slate-400">&copy; {{ now()->year }} Bimbel Missi. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
