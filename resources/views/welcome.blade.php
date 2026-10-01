@php
    $whatsappNumber = '62895392551182';
    $whatsappMessage = "Halo Admin Bimbel Missi, saya ingin bertanya dan berkonsultasi mengenai les privat.";
    $whatsappUrl = 'https://wa.me/' . $whatsappNumber . '?text=' . urlencode($whatsappMessage);
    $formUrl = 'https://docs.google.com/forms/d/e/1FAIpQLSe56xKm0Gpq36OrtELzSy2VMTcZMYqee2os50e4JcZWestU6g/viewform?usp=publish-editor';
    $heroVideoExists = file_exists(public_path('videos/hero-belajar.mp4'));
    $canonicalUrl = url('/');
    $ogImage = asset('images/Profil1.jpeg');
    $programs = [
        ['title' => 'Privat Calistung', 'category' => 'Usia dini', 'goal' => 'Membantu anak membaca, menulis, dan berhitung dengan cara yang menyenangkan.', 'mode' => 'Tutor datang ke rumah', 'cta' => 'Tanya Program Calistung', 'tone' => 'bg-retro-cream text-dark-ink border-acid-lime/40'],
        ['title' => 'Privat Matematika', 'category' => 'Mapel inti', 'goal' => 'Pendampingan matematika untuk membantu pemahaman konsep, latihan soal, dan rasa percaya diri anak saat belajar hitungan.', 'mode' => 'Tutor datang ke rumah atau online', 'cta' => 'Tanya Program Matematika', 'tone' => 'bg-blue-50 text-dark-ink border-electric-blue/20'],
        ['title' => 'Les Mapel SD', 'category' => 'Sekolah dasar', 'goal' => 'Pendampingan PR, latihan soal, dan penguatan materi sekolah.', 'mode' => 'Tutor datang ke rumah', 'cta' => 'Konsultasi Les SD', 'tone' => 'bg-blue-50 text-dark-ink border-electric-blue/20'],
        ['title' => 'Les SMP dan SMA', 'category' => 'Sekolah menengah', 'goal' => 'Belajar lebih terarah untuk mapel inti dan persiapan evaluasi sekolah.', 'mode' => 'Tutor datang ke rumah atau online', 'cta' => 'Cari Tutor Mapel', 'tone' => 'bg-blue-50 text-dark-ink border-electric-blue/20'],
        ['title' => 'Bahasa Inggris', 'category' => 'Bahasa', 'goal' => 'Meningkatkan vocabulary, speaking, grammar, dan percaya diri berbahasa.', 'mode' => 'Privat atau kelompok kecil', 'cta' => 'Cari Tutor Bahasa Inggris', 'tone' => 'bg-yellow-50 text-dark-ink border-vivid-amber/40'],
        ['title' => 'Mengaji', 'category' => 'Keagamaan', 'goal' => "Bimbingan baca tulis Al-Qur'an dengan pendampingan yang sabar.", 'mode' => 'Tutor datang ke rumah', 'cta' => 'Tanya Program Mengaji', 'tone' => 'bg-retro-cream text-dark-ink border-acid-lime/40'],
        ['title' => 'Menggambar, Mewarnai, dan Crafting', 'category' => 'Kreativitas', 'goal' => 'Mengasah kreativitas, motorik halus, dan keberanian berekspresi lewat aktivitas seni yang menyenangkan.', 'mode' => 'Privat atau kelompok kecil', 'cta' => 'Tanya Kelas Kreatif', 'tone' => 'bg-blue-50 text-dark-ink border-electric-blue/20'],
        ['title' => 'Persiapan Ujian', 'category' => 'Tes dan evaluasi', 'goal' => 'Latihan soal dan review materi untuk menghadapi ujian dengan lebih siap.', 'mode' => 'Tutor datang ke rumah atau online', 'cta' => 'Cek Program Ujian', 'tone' => 'bg-yellow-50 text-dark-ink border-vivid-amber/40'],
        ['title' => 'Privat Renang', 'category' => 'Skill anak', 'goal' => 'Latihan renang dasar sampai mahir bersama instruktur.', 'mode' => 'Lokasi menyesuaikan', 'cta' => 'Cek Jadwal Renang', 'tone' => 'bg-blue-50 text-dark-ink border-electric-blue/20'],
        ['title' => 'Les Tari', 'category' => 'Seni gerak', 'goal' => 'Membantu anak belajar tari dengan pendampingan yang menyenangkan, terarah, dan sesuai minatnya.', 'mode' => 'Privat atau kelompok kecil', 'cta' => 'Tanya Program Tari', 'tone' => 'bg-retro-cream text-dark-ink border-acid-lime/40'],
        ['title' => 'Bahasa Mandarin dan Jepang', 'category' => 'Bahasa asing', 'goal' => 'Belajar kosakata, percakapan dasar, dan pengenalan budaya dengan pendekatan bertahap.', 'mode' => 'Online atau privat terjadwal', 'cta' => 'Cari Tutor Bahasa Asing', 'tone' => 'bg-yellow-50 text-dark-ink border-vivid-amber/40'],
        ['title' => 'Event dan Workshop Bulanan', 'category' => 'Kegiatan tematik', 'goal' => 'Kegiatan belajar tematik untuk menambah pengalaman anak lewat workshop berkala yang seru dan terarah.', 'mode' => 'Jadwal event menyesuaikan', 'cta' => 'Tanya Jadwal Workshop', 'tone' => 'bg-blue-50 text-dark-ink border-electric-blue/20'],
    ];
    $pricePackages = [
        [
            'price' => 'Rp 200k',
            'sessions' => '1 bulan | 4 sesi',
            'frequency' => '1 minggu 1x',
            'highlight' => 'Paket bulanan',
            'accent' => 'bg-white border-dark-ink/15',
            'badge' => null,
        ],
        [
            'price' => 'Rp 380k',
            'sessions' => '1 bulan | 8 sesi',
            'frequency' => '1 minggu 2x',
            'highlight' => 'Lebih hemat',
            'accent' => 'bg-retro-cream border-acid-lime/40',
            'badge' => 'Best value',
        ],
    ];
    $priceIncludes = [
        'FREE Transportation',
        'FREE Registration',
        'FREE Program Planning',
        'Private 1 guru 1 siswa',
        'LKPD & interactive activity kit',
        'Science experiment & engaging skill time',
        'Laporan siswa',
    ];
    $faqItems = [
        ['q' => 'Apakah tutor datang ke rumah?', 'a' => 'Ya, layanan utama Bimbel Missi adalah les privat ke rumah. Untuk beberapa program, pembelajaran online atau lokasi khusus dapat menyesuaikan kebutuhan.'],
        ['q' => 'Apakah jadwal belajar dapat dipilih?', 'a' => 'Jadwal dapat dikonsultasikan terlebih dahulu. Admin akan membantu menyesuaikan kebutuhan orang tua, siswa, dan ketersediaan tutor.'],
        ['q' => 'Berapa biaya les privat?', 'a' => 'Biaya disesuaikan dengan jenjang, program, lokasi, dan jumlah pertemuan. Konsultasi kebutuhan dan pencarian tutor tidak dikenakan biaya.'],
        ['q' => 'Apakah tutor dapat diganti?', 'a' => 'Jika ada kendala kecocokan atau jadwal, orang tua dapat berkonsultasi dengan admin agar dicari solusi sesuai kebijakan layanan.'],
        ['q' => 'Apakah tersedia pembelajaran online?', 'a' => 'Beberapa program dapat dilakukan secara online, terutama bahasa Inggris, speaking, TOEFL, atau pendampingan mapel tertentu.'],
        ['q' => 'Apakah orang tua menerima laporan belajar?', 'a' => 'Ya. Orang tua dapat memantau materi yang dipelajari, catatan tutor, pemahaman siswa, dan dokumentasi kegiatan jika tersedia.'],
        ['q' => 'Area mana saja yang dilayani?', 'a' => 'Saat ini layanan Bimbel Missi tersedia untuk area Wonosobo, Magelang, dan Purwokerto.'],
        ['q' => 'Bagaimana cara mendaftar?', 'a' => 'Klik tombol Konsultasi Gratis, isi kebutuhan belajar anak, lalu admin akan membantu mencarikan program dan tutor yang sesuai.'],
    ];
@endphp
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Privat ke Rumah untuk Anak | Bimbel Missi</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/logo.png') }}?v=3" type="image/png">

    <meta name="description" content="Bimbel Missi menyediakan tutor privat ke rumah untuk Calistung, SD, SMP, SMA, Bahasa Inggris, bahasa asing, mengaji, renang, seni, dan workshop anak. Area layanan mencakup Wonosobo, Magelang, dan Purwokerto.">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Les Privat ke Rumah untuk Anak | Bimbel Missi">
    <meta property="og:description" content="Tutor privat ke rumah dengan jadwal fleksibel, pembelajaran personal, dan laporan perkembangan untuk orang tua.">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta name="twitter:card" content="summary_large_image">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@600;700;800;900&family=Space+Grotesk:wght@500;700&family=EB+Garamond:ital,wght@0,500;0,700;1,500;1,700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@600;700;800;900&family=Space+Grotesk:wght@500;700&family=EB+Garamond:ital,wght@0,500;0,700;1,500;1,700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@600;700;800;900&family=Space+Grotesk:wght@500;700&family=EB+Garamond:ital,wght@0,500;0,700;1,500;1,700&display=swap"></noscript>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                        mono: ['Space Grotesk', 'monospace'],
                        serif: ['EB Garamond', 'serif'],
                    },
                    colors: {
                        'electric-blue': '#2563eb',
                        'acid-lime': '#d9f99d',
                        'vivid-amber': '#fbbf24',
                        'neon-pink': '#f43f5e',
                        'dark-ink': '#0f172a',
                        'retro-cream': '#fffbeb',
                        'secondary-container': '#d4f01e',
                        'tertiary-fixed': '#ffddb8',
                        'neon-lilac': '#c084fc',
                    }
                }
            }
        }
    </script>

    <style>
        * { letter-spacing: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .brutal-shadow { box-shadow: 4px 4px 0px #0f172a; }
        .brutal-shadow-lg { box-shadow: 6px 6px 0px #0f172a; }
        .brutal-shadow-xl { box-shadow: 8px 8px 0px #0f172a; }
        .brutal-shadow-sm { box-shadow: 2px 2px 0px #0f172a; }
        .brutal-shadow-hover { transition: all 0.15s ease-in-out; }
        .brutal-shadow-hover:hover { transform: translate(2px, 2px); box-shadow: 2px 2px 0px #0f172a; }

        .bg-grid-pattern {
            background-image:
                linear-gradient(to right, rgba(15, 23, 42, 0.07) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(15, 23, 42, 0.07) 1px, transparent 1px);
            background-size: 28px 28px;
        }
        .bg-dot-pattern {
            background-image: radial-gradient(rgba(15, 23, 42, 0.15) 1.5px, transparent 1.5px);
            background-size: 18px 18px;
        }

        @keyframes scrollUp { from { transform: translateY(0); } to { transform: translateY(-50%); } }
        @keyframes scrollDown { from { transform: translateY(-50%); } to { transform: translateY(0); } }
        .marquee-container {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1.15fr);
            gap: 1rem;
            align-items: start;
            height: 560px;
            overflow: hidden;
            mask-image: linear-gradient(to bottom, transparent, black 10%, black 90%, transparent);
            -webkit-mask-image: linear-gradient(to bottom, transparent, black 10%, black 90%, transparent);
        }
        @media (min-width: 1024px) { .marquee-container { height: 680px; } }
        .marquee-col { display: flex; flex-direction: column; gap: 1.25rem; height: max-content; will-change: transform; }
        .marquee-up { animation: scrollUp 25s linear infinite; }
        .marquee-down { animation: scrollDown 25s linear infinite; }
        .marquee-up:hover, .marquee-down:hover { animation-play-state: paused; }

        .nav-glass {
            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 2px solid #0f172a;
        }
        .hero-pattern {
            background: linear-gradient(115deg, #fffbeb 0%, #fef3c7 50%, #fef08a 100%);
            position: relative;
        }
        .hero-pattern::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .4;
            background-image:
                linear-gradient(90deg, rgba(15, 23, 42, 0.055) 1px, transparent 1px),
                linear-gradient(0deg, rgba(15, 23, 42, 0.04) 1px, transparent 1px);
            background-size: 44px 44px;
        }
        .feature-pill {
            display: flex;
            align-items: center;
            gap: .55rem;
            border-radius: 9999px;
            border: 2px solid #0f172a;
            background: #d9f99d;
            padding: .7rem .9rem;
            box-shadow: 4px 4px 0px #0f172a;
        }
        .feature-pill::before {
            content: "";
            width: .48rem;
            height: .48rem;
            flex: 0 0 auto;
            border-radius: 9999px;
            background: #0f172a;
        }
        .quiet-strip { position: relative; overflow: hidden; background: rgba(255, 255, 255, .95); }
        .story-section {
            position: relative;
            overflow: hidden;
            background: linear-gradient(112deg, #fffbeb 0%, #ffffff 50%, #fef3c7 100%);
        }
        .story-section::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .3;
            background-image:
                linear-gradient(90deg, rgba(15, 23, 42, 0.055) 1px, transparent 1px),
                linear-gradient(0deg, rgba(15, 23, 42, 0.04) 1px, transparent 1px);
            background-size: 44px 44px;
        }
        .story-photo { position: relative; overflow: hidden; }
        .story-photo::after {
            content: "";
            position: absolute;
            inset: auto 0 0;
            height: 34%;
            background: linear-gradient(180deg, transparent, rgba(15,23,42,.72));
        }
        .handline { position: relative; display: inline; }
        .handline::after {
            content: "";
            position: absolute;
            left: 0; right: 0;
            bottom: .08em;
            height: .28em;
            z-index: -1;
            background: #d9f99d;
        }
        .natural-list-item {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 1rem;
            align-items: start;
            padding-block: 1.15rem;
            border-bottom: 1px solid rgba(15, 23, 42, 0.1);
        }
        .natural-list-item:last-child { border-bottom: 0; }
        .benefit-index {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 9999px;
            background: #d9f99d;
            color: #0f172a;
            font-size: .78rem;
            font-weight: 900;
            border: 2px solid #0f172a;
        }
        .video-card { aspect-ratio: 9 / 16; }
        .section-kicker {
            color: #2563eb;
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            font-family: 'Space Grotesk', monospace;
        }
        .focus-ring:focus-visible { outline: 3px solid rgba(37, 99, 235, .4); outline-offset: 4px; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
            .hero-video { display: none; }
        }
        @media (max-width: 639px) {
            .hero-pattern::before { opacity: .25; background-size: 28px 28px; }
            .video-card { aspect-ratio: 5 / 7; }
        }
    </style>

    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => ['LocalBusiness', 'EducationalOrganization'],
            'name' => 'Bimbel Missi',
            'url' => $canonicalUrl,
            'image' => $ogImage,
            'areaServed' => ['Wonosobo', 'Magelang', 'Purwokerto'],
            'description' => 'Layanan les privat ke rumah untuk anak dengan tutor personal dan laporan perkembangan belajar.',
            'telephone' => '+' . $whatsappNumber,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => collect($faqItems)->map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq['q'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['a'],
                ],
            ])->values()->all(),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
</head>
<body class="bg-white text-slate-900 antialiased overflow-x-hidden">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[70] focus:rounded-lg focus:bg-white focus:px-4 focus:py-3 focus:font-bold focus:text-electric-blue">Lewati ke konten</a>

    <nav class="nav-glass fixed inset-x-0 top-0 z-50">
        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="#home" class="focus-ring flex items-center gap-3 rounded-lg" aria-label="Bimbel Missi">
                <img src="{{ asset('images/logo1.png') }}" alt="Logo Bimbel Missi" class="h-12 w-12 rounded-full border-[2px] border-dark-ink object-cover transition-transform hover:scale-105">
                <span class="text-sm font-black text-dark-ink sm:text-base font-display">Missi Private Course</span>
            </a>

            <div class="hidden items-center gap-7 text-sm font-bold text-slate-700 lg:flex">
                <a class="hover:text-electric-blue" href="#home">Beranda</a>
                <a class="hover:text-electric-blue" href="#program">Program</a>
                <a class="hover:text-electric-blue" href="#harga">Harga</a>
                <a class="hover:text-electric-blue" href="#cara-kerja">Cara Kerja</a>
                <a class="hover:text-electric-blue" href="#laporan">Laporan</a>
                <a class="hover:text-electric-blue" href="#tutor">Tutor</a>
                <a class="hover:text-electric-blue" href="#faq">FAQ</a>
            </div>

            <div class="hidden items-center gap-3 lg:flex">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="focus-ring rounded-full px-4 py-2 text-sm font-extrabold text-dark-ink hover:bg-retro-cream">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="focus-ring rounded-full px-4 py-2 text-sm font-extrabold text-dark-ink hover:bg-retro-cream">Login Portal</a>
                    @endauth
                @endif
                <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring rounded-xl border-2 border-dark-ink brutal-shadow brutal-shadow-hover bg-electric-blue px-6 py-3 text-sm font-black text-white transition">
                    Konsultasi Gratis
                </a>
            </div>

            <button id="mobile-menu-btn" type="button" class="focus-ring inline-flex h-11 w-11 items-center justify-center rounded-lg border-2 border-dark-ink bg-white text-dark-ink lg:hidden" aria-label="Buka menu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
            </button>
        </div>

        <div id="mobile-menu" class="hidden border-t-2 border-dark-ink bg-white px-4 py-4 shadow-lg lg:hidden">
            <div class="grid gap-2 text-sm font-bold text-slate-700">
                <a class="rounded-lg px-3 py-2 hover:bg-retro-cream" href="#home">Beranda</a>
                <a class="rounded-lg px-3 py-2 hover:bg-retro-cream" href="#program">Program</a>
                <a class="rounded-lg px-3 py-2 hover:bg-retro-cream" href="#harga">Harga</a>
                <a class="rounded-lg px-3 py-2 hover:bg-retro-cream" href="#cara-kerja">Cara Kerja</a>
                <a class="rounded-lg px-3 py-2 hover:bg-retro-cream" href="#laporan">Laporan</a>
                <a class="rounded-lg px-3 py-2 hover:bg-retro-cream" href="#tutor">Tutor</a>
                <a class="rounded-lg px-3 py-2 hover:bg-retro-cream" href="#faq">FAQ</a>
                @auth
                    <a class="rounded-lg px-3 py-2 hover:bg-retro-cream" href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a class="rounded-lg px-3 py-2 hover:bg-retro-cream" href="{{ route('login') }}">Login Portal</a>
                @endauth
                <a class="mt-2 rounded-xl border-2 border-dark-ink brutal-shadow brutal-shadow-hover bg-electric-blue px-4 py-3 text-center font-black text-white" href="{{ $whatsappUrl }}" target="_blank">Konsultasi Gratis</a>
            </div>
        </div>
    </nav>

    <main id="main-content">
        <section id="home" class="hero-pattern bg-grid-pattern relative overflow-hidden pt-16 sm:pt-16 lg:pt-20">
            <div class="brand-ring hero-ring-left hidden lg:block" aria-hidden="true"></div>
            <div class="brand-ring hero-ring-right hidden lg:block" aria-hidden="true"></div>
            <div class="relative z-10 mx-auto grid min-h-[auto] max-w-7xl items-center gap-10 px-4 pt-10 pb-14 sm:px-6 sm:pt-12 sm:pb-16 lg:min-h-[680px] lg:grid-cols-[.9fr_1.1fr] lg:gap-12 lg:px-8 lg:pt-16 lg:pb-24 xl:gap-16">
                <div class="max-w-2xl pt-3 sm:pt-4 lg:pt-2">
                    <p class="mb-5 inline-flex rounded-full border-2 border-dark-ink bg-electric-blue px-4 py-2 text-sm font-extrabold text-white shadow-sm">
                        Pendaftaran Tahun Ajaran 2026/2027 Dibuka
                    </p>
                    <h1 class="max-w-3xl text-[2.85rem] font-black leading-[.96] text-dark-ink sm:text-5xl sm:leading-tight lg:text-6xl xl:text-[4.3rem] font-display tracking-tight">
                        Les Privat ke Rumah untuk Anak
                    </h1>
                    <p class="mt-5 max-w-2xl text-[1rem] font-semibold leading-7 text-slate-600 sm:mt-6 sm:text-lg sm:leading-8">
                        Bimbel Missi membantu anak belajar dengan tutor yang ramah, jadwal fleksibel, materi personal, serta didukung sistem untuk mencatat laporan perkembangan belajar.
                    </p>
                    <div class="mt-8 flex max-w-xl flex-col gap-3 sm:flex-row">
                        <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring inline-flex min-h-14 flex-1 items-center justify-center rounded-xl border-2 border-dark-ink brutal-shadow brutal-shadow-hover bg-electric-blue px-6 py-3 text-center text-base font-black text-white transition hover:bg-blue-600 sm:text-sm sm:whitespace-nowrap">
                            Konsultasi Gratis via WhatsApp
                        </a>
                        <a href="#laporan" class="focus-ring inline-flex min-h-14 flex-1 items-center justify-center rounded-xl border-2 border-dark-ink brutal-shadow brutal-shadow-hover bg-white px-6 py-3 text-center text-base font-black text-dark-ink transition hover:bg-retro-cream sm:text-sm sm:whitespace-nowrap">
                            Lihat Laporan Belajar
                        </a>
                    </div>
                    <div class="mt-8 grid max-w-2xl gap-3 text-sm font-black text-slate-700 sm:flex sm:flex-wrap">
                        <span class="feature-pill">Tutor datang ke rumah</span>
                        <span class="feature-pill">Jadwal fleksibel</span>
                        <span class="feature-pill">Ada laporan belajar</span>
                        <span class="feature-pill">Wonosobo, Magelang, Purwokerto</span>
                    </div>
                </div>

                <div class="relative mx-auto w-full max-w-[620px] pt-2 lg:pt-8">
                    <!-- Decorative Background Accents -->
                            <div class="absolute right-[-22px] top-[34px] w-[72%] h-[74%] rounded-full border-[20px] border-vivid-amber/20 -rotate-[10deg] -z-10 hidden md:block"></div>
                            <div class="absolute left-[8%] bottom-[8%] w-[40%] h-[30%] rounded-full border-[12px] border-dark-ink/10 rotate-[12deg] -z-10 hidden md:block"></div>

                    <!-- Static Hero Image Container (2 Photos) -->
                    <div class="relative z-10 w-full h-[450px] sm:h-[550px] lg:h-[600px] mt-10 lg:mt-0">
                        
                        <!-- Image 1 -->
                        <div class="absolute top-0 left-0 w-[75%] h-[70%] sm:h-[75%] rounded-3xl border-4 border-slate-900 bg-white p-2 brutal-shadow-lg transform -rotate-2 hover:rotate-0 hover:z-20 transition duration-300">
                            <div class="h-full w-full overflow-hidden rounded-2xl border-2 border-slate-900">
                                @if($heroVideoExists)
                                    <video class="h-full w-full object-cover" autoplay muted loop playsinline poster="{{ asset('images/Profil1.jpeg') }}">
                                        <source src="{{ asset('videos/hero-belajar.mp4') }}" type="video/mp4">
                                    </video>
                                @else
                                    <img src="{{ asset('images/Profil1.jpeg') }}" alt="Kegiatan belajar Bimbel Missi" fetchpriority="high" decoding="sync" class="h-full w-full object-cover">
                                @endif
                            </div>
                        </div>

                        <!-- Image 2 -->
                        <div class="absolute bottom-0 right-0 w-[70%] h-[65%] sm:h-[70%] rounded-3xl border-4 border-slate-900 bg-white p-2 brutal-shadow-xl transform rotate-3 hover:rotate-0 hover:z-20 transition duration-300 z-10">
                            <div class="h-full w-full overflow-hidden rounded-2xl border-2 border-slate-900">
                                <img src="{{ asset('images/Profile2.jpeg') }}" alt="Kegiatan belajar" fetchpriority="high" decoding="sync" class="h-full w-full object-cover">
                            </div>
                        </div>

                        <!-- Floating Badges (Neo-Brutalist) -->
                        <div class="absolute top-1/2 -left-4 sm:-left-8 -translate-y-1/2 rounded-xl border-2 border-slate-900 bg-electric-blue px-4 py-3 brutal-shadow z-30 animate-bounce" style="animation-duration: 3s;">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-slate-900 bg-white text-slate-900">
                                    <svg class="h-6 w-6 text-electric-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-black uppercase text-white">Metode Belajar</p>
                                    <p class="text-sm font-black text-vivid-amber">Menyenangkan</p>
                                </div>
                            </div>
                        </div>

                        <div class="absolute -right-4 bottom-8 sm:bottom-16 rounded-xl border-2 border-slate-900 bg-vivid-amber px-4 py-3 brutal-shadow z-30">
                            <div class="flex items-center gap-2">
                                <svg class="h-5 w-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-sm font-black text-slate-900">Jadwal Fleksibel</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="landing-stats" aria-label="Kepercayaan layanan" class="relative z-20 -mt-2 px-4 sm:-mt-10 sm:px-6 lg:px-8">
            <div class="quiet-strip mx-auto rounded-xl border-4 border-slate-900 brutal-shadow">
                <div class="relative mx-auto grid max-w-7xl items-start gap-5 px-5 py-6 sm:px-6 lg:grid-cols-[.85fr_1.15fr] lg:px-8">
                    <div>
                        <p class="text-xs font-mono font-bold uppercase text-electric-blue">Belajar privat yang lebih tertata</p>
                        <p class="mt-2 max-w-xl text-xl font-black leading-8 text-dark-ink">Tutor datang ke rumah, proses belajar dibantu admin, dan laporan sesi dapat dicatat.</p>
                        <p class="mt-3 max-w-xl text-sm leading-7 text-slate-600">Angka di bawah ini diambil dari aktivitas belajar yang sudah tercatat di sistem Missi.</p>
                    </div>
                    <div class="grid self-start content-start gap-4 sm:grid-cols-2">
                        @foreach(($landingStats ?? []) as $stat)
                            <article class="rounded-xl border-2 border-slate-900 brutal-shadow bg-white/90 p-4">
                                <p
                                    class="landing-stat-value text-3xl font-black leading-none {{ $stat['accent'] }}"
                                    data-countup-target="{{ $stat['target'] ?? 0 }}"
                                    data-countup-suffix="{{ $stat['suffix'] ?? '' }}"
                                >{{ $stat['value'] }}</p>
                                <p class="mt-2 text-sm font-bold leading-6 text-slate-600">{{ $stat['label'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="story-section py-16 sm:py-20">
            <div class="relative z-10 mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-[1.04fr_.96fr] lg:px-8">
                <div>
                    <p class="section-kicker">Masalah Orang Tua</p>
                    <h2 class="mt-3 max-w-3xl text-3xl font-black leading-tight text-slate-950 sm:text-5xl font-display tracking-tight">
                        Mencari les yang cocok itu seringnya bukan soal <span class="handline">materi saja</span>.
                    </h2>
                    <p class="mt-5 text-base leading-8 text-slate-600">
                        Setiap anak punya ritme belajar yang berbeda. Ada yang butuh pendampingan membaca, ada yang perlu latihan soal, ada juga yang butuh tutor yang sabar dan cocok dengan karakternya.
                    </p>
                    <p class="mt-4 text-base leading-8 text-slate-600">
                        Bimbel Missi membantu mencarikan tutor yang sesuai, mengatur jadwal belajar, dan menyediakan laporan perkembangan agar pembelajaran lebih terarah.
                    </p>
                    <div class="mt-7 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-xl border-4 border-dark-ink bg-white p-4 brutal-shadow transition-transform hover:-translate-y-1">
                            <div class="mb-3 h-2 w-10 bg-electric-blue"></div>
                            <p class="text-sm font-black text-slate-950">Cocok dengan anak</p>
                            <p class="mt-1 text-sm font-semibold leading-6 text-slate-700">Tutor dan cara belajar disesuaikan.</p>
                        </div>
                        <div class="rounded-xl border-4 border-dark-ink bg-white p-4 brutal-shadow transition-transform hover:-translate-y-1">
                            <div class="mb-3 h-2 w-10 bg-neon-pink"></div>
                            <p class="text-sm font-black text-slate-950">Jadwal realistis</p>
                            <p class="mt-1 text-sm font-semibold leading-6 text-slate-700">Dikonsultasikan dengan keluarga.</p>
                        </div>
                        <div class="rounded-xl border-4 border-dark-ink bg-white p-4 brutal-shadow transition-transform hover:-translate-y-1">
                            <div class="mb-3 h-2 w-10 bg-acid-lime"></div>
                            <p class="text-sm font-black text-slate-950">Ada catatan belajar</p>
                            <p class="mt-1 text-sm font-semibold leading-6 text-slate-700">Perkembangan anak lebih mudah dilihat.</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="story-photo rounded-2xl border-4 border-slate-900 brutal-shadow overflow-hidden">
                        <img src="{{ asset('images/Profile3.jpeg') }}" alt="Kegiatan belajar anak bersama Missi" class="h-[320px] w-full object-cover sm:h-[420px]">
                        <div class="absolute inset-x-0 bottom-0 z-10 p-6 text-white">
                            <p class="text-sm font-black uppercase text-retro-cream">Pendampingan lebih personal</p>
                            <p class="mt-2 max-w-sm text-2xl font-black leading-8">Anak belajar nyaman, orang tua tetap tahu prosesnya.</p>
                        </div>
                    </div>
                        <div class="absolute -left-4 top-6 hidden rounded-xl border-2 border-dark-ink brutal-shadow bg-white p-4 lg:block">
                            <p class="text-xs font-mono font-bold uppercase text-electric-blue">Dibantu admin</p>
                            <p class="mt-1 text-sm font-bold text-slate-700">Mulai dari kebutuhan, tutor, sampai jadwal.</p>
                        </div>
                </div>
            </div>
        </section>

        <section id="keunggulan" class="bg-white py-20">
            <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-[.9fr_1.1fr] lg:px-8">
                <div class="lg:sticky lg:top-28 lg:self-start">
                    <p class="section-kicker">Keunggulan</p>
                    <h2 class="mt-3 text-3xl font-black leading-tight text-slate-950 sm:text-5xl font-display tracking-tight">Dibangun untuk keluarga yang butuh pendamping belajar yang pas.</h2>
                    <p class="mt-5 text-base leading-8 text-slate-600">Pendekatannya personal, tetapi tetap dibantu sistem dan admin agar proses belajar lebih tertata.</p>
                    <img src="{{ asset('images/Profile4.jpeg') }}" alt="Dokumentasi kegiatan belajar Missi" class="mt-8 h-64 w-full rounded-2xl border-4 border-dark-ink object-cover brutal-shadow">
                </div>
                <div class="divide-y divide-dark-ink/10 rounded-lg border-y-2 border-dark-ink/10">
                    @foreach([
                        ['Tutor terseleksi', 'Tutor dipilih berdasarkan kebutuhan siswa dan bidang yang diajarkan.'],
                        ['Pembelajaran personal', 'Materi dan cara belajar disesuaikan dengan kemampuan serta tujuan anak.'],
                        ['Tutor datang ke rumah', 'Anak dapat belajar lebih nyaman tanpa orang tua perlu antar jemput.'],
                        ['Jadwal fleksibel', 'Waktu belajar dikonsultasikan agar sesuai dengan aktivitas keluarga.'],
                        ['Laporan belajar tersedia', 'Missi memiliki sistem untuk mencatat materi, catatan tutor, pemahaman, dan dokumentasi sesi.'],
                        ['Admin bantu koordinasi', 'Kebutuhan, kendala, dan penyesuaian tutor dibantu oleh tim Bimbel Missi.'],
                    ] as $index => $item)
                        <article class="natural-list-item">
                            <span class="benefit-index">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <div class="grid gap-2 sm:grid-cols-[.42fr_1fr] sm:gap-6">
                                <h3 class="text-xl font-black leading-7 text-slate-950 font-display tracking-tight">{{ $item[0] }}</h3>
                                <p class="text-base leading-8 text-slate-600">{{ $item[1] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="program" class="bg-retro-cream py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <p class="section-kicker">Pilihan Program</p>
                        <h2 class="mt-3 text-3xl font-black leading-tight text-slate-950 sm:text-4xl font-display tracking-tight">Program Belajar untuk Kebutuhan Anak</h2>
                        <p class="mt-4 text-base leading-8 text-slate-600">Pilih program sesuai usia, jenjang, minat, dan tujuan belajar. Jika masih bingung, admin akan bantu merekomendasikan pilihan yang tepat.</p>
                    </div>
                    <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring inline-flex rounded-xl border-2 border-dark-ink bg-electric-blue px-6 py-3 text-sm font-black text-white brutal-shadow brutal-shadow-hover transition hover:bg-dark-ink">
                        Konsultasi Program
                    </a>
                </div>

                <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($programs as $program)
                        <article class="group relative flex flex-col justify-between overflow-hidden rounded-2xl border-4 border-dark-ink bg-white p-6 brutal-shadow transition-all duration-300 hover:-translate-y-2 hover:brutal-shadow-hover">
                            <!-- Top Bar -->
                            <div class="absolute inset-x-0 top-0 h-2 bg-dark-ink"></div>
                            
                            <div class="pt-2">
                                <span class="inline-flex rounded-full border-2 border-dark-ink px-3 py-1 text-xs font-black shadow-[2px_2px_0px_#0f172a] {{ $program['tone'] }}">{{ $program['category'] }}</span>
                                <h3 class="mt-5 text-xl font-black leading-tight text-slate-900 transition-colors group-hover:text-electric-blue font-display tracking-tight">{{ $program['title'] }}</h3>
                                <p class="mt-3 text-sm font-bold leading-relaxed text-slate-600">{{ $program['goal'] }}</p>
                            </div>
                            
                            <div class="mt-auto pt-6">
                                <div class="flex items-center justify-between border-t-4 border-dark-ink pt-5">
                                    <a href="{{ $whatsappUrl }}" target="_blank" class="inline-flex items-center gap-1 text-sm font-black text-electric-blue transition-colors hover:text-vivid-amber">
                                        {{ $program['cta'] }}
                                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                    <div class="text-right">
                                        <span class="block text-base font-black text-vivid-amberDark">Rp 50.000</span>
                                        <span class="block text-[11px] font-black text-slate-500 uppercase font-mono">per sesi</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="harga" class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <p class="section-kicker">Pricelist</p>
                        <h2 class="mt-3 text-3xl font-black leading-tight text-slate-950 sm:text-4xl font-display tracking-tight">Paket Belajar Privat Home Visit</h2>
                        <p class="mt-4 text-base leading-8 text-slate-600">
                            Pricelist ini berlaku untuk area Wonosobo. Untuk kebutuhan lokasi lain, program khusus, atau frekuensi belajar berbeda, admin akan bantu informasikan penyesuaian biayanya.
                        </p>
                    </div>
                    <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring inline-flex rounded-xl border-2 border-dark-ink bg-electric-blue px-6 py-3 text-sm font-black text-white brutal-shadow brutal-shadow-hover transition hover:bg-dark-ink">
                        Tanya Paket Lainnya
                    </a>
                </div>

                <div class="mt-10 grid gap-6 xl:grid-cols-[1.1fr_.9fr]">
                    <div class="rounded-3xl border-4 border-dark-ink bg-retro-cream p-6 brutal-shadow sm:p-8">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <p class="inline-block bg-dark-ink px-2 py-1 text-xs font-black uppercase tracking-widest text-retro-cream font-mono">Pricelist Wonosobo</p>
                                <h3 class="mt-4 text-3xl font-black text-dark-ink sm:text-4xl font-display tracking-tight">Privat Class - Home Visit</h3>
                                <p class="mt-3 text-sm font-black text-slate-700">Durasi 60-90 minutes</p>
                            </div>
                            <div class="rounded-full border-2 border-dark-ink bg-white px-4 py-2 text-xs font-black uppercase tracking-wide text-dark-ink shadow-[2px_2px_0px_#0f172a]">
                                Paket Bulanan
                            </div>
                        </div>

                        <div class="mt-8 grid gap-4 lg:grid-cols-2">
                            @foreach($pricePackages as $package)
                                <article class="relative rounded-2xl border-4 border-dark-ink p-5 brutal-shadow bg-white transition hover:-translate-y-1">
                                    @if($package['badge'])
                                        <span class="absolute -top-4 left-4 rounded-full border-2 border-dark-ink bg-vivid-amber px-3 py-1 text-xs font-black uppercase tracking-wide text-dark-ink shadow-[2px_2px_0px_#0f172a]">
                                            {{ $package['badge'] }}
                                        </span>
                                    @endif

                                    <p class="text-xs font-black uppercase tracking-widest text-slate-500 font-mono">{{ $package['highlight'] }}</p>
                                    <p class="mt-2 text-4xl font-black leading-none text-dark-ink">{{ $package['price'] }}</p>
                                    <div class="mt-4 h-1 w-full bg-dark-ink"></div>
                                    <p class="mt-4 text-base font-black text-slate-900">{{ $package['sessions'] }}</p>
                                    <p class="mt-1 text-sm font-bold text-slate-600">({{ $package['frequency'] }})</p>
                                </article>
                            @endforeach
                        </div>

                        <div class="mt-6 flex flex-col gap-3 rounded-2xl border-4 border-dark-ink bg-white px-5 py-4 brutal-shadow-sm sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm font-black text-electric-blue">Register Now</p>
                                <p class="mt-1 text-xs font-bold leading-6 text-slate-500">Konsultasi gratis sebelum menentukan paket belajar.</p>
                            </div>
                            <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring inline-flex items-center justify-center rounded-xl border-2 border-dark-ink bg-[#2f7d57] px-5 py-3 text-sm font-black text-white shadow-[2px_2px_0px_#0f172a] transition hover:bg-[#276949]">
                                0895392551182
                            </a>
                        </div>
                    </div>

                    <div class="grid gap-6">
                        <div class="rounded-3xl border-4 border-dark-ink bg-electric-blue p-6 brutal-shadow sm:p-8">
                            <p class="inline-block bg-white px-2 py-1 text-xs font-black uppercase tracking-widest text-dark-ink font-mono">Include</p>
                            <h3 class="mt-4 text-2xl font-black text-white font-display tracking-tight">Sudah termasuk dalam paket</h3>
                            <div class="mt-6 grid gap-3">
                                @foreach($priceIncludes as $item)
                                    <div class="flex items-start gap-3 rounded-xl border-2 border-dark-ink bg-white px-4 py-3 shadow-[2px_2px_0px_#0f172a] transition hover:translate-x-1">
                                        <span class="mt-0.5 inline-flex h-5 w-5 shrink-0 items-center justify-center text-lg font-black text-electric-blue">+</span>
                                        <p class="text-sm font-black leading-6 text-slate-900">{{ $item }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="rounded-3xl border-4 border-dark-ink bg-white p-6 brutal-shadow sm:p-8">
                            <p class="inline-block bg-dark-ink px-2 py-1 text-xs font-black uppercase tracking-widest text-retro-cream font-mono">Kontak & Area</p>
                            <div class="mt-5 grid gap-4">
                                <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring inline-flex items-center justify-between gap-4 rounded-xl border-4 border-dark-ink px-4 py-4 text-left shadow-[2px_2px_0px_#0f172a] transition hover:-translate-y-1 hover:shadow-[4px_4px_0px_#0f172a] hover:bg-electric-blue hover:text-white group">
                                    <div>
                                        <p class="text-xs font-black uppercase tracking-wide text-slate-400 group-hover:text-white/80">Contact</p>
                                        <p class="mt-1 text-base font-black text-slate-950 group-hover:text-white">0895392551182</p>
                                    </div>
                                    <span class="rounded-full border-2 border-dark-ink bg-acid-lime px-3 py-1 text-xs font-black text-dark-ink">Hubungi</span>
                                </a>
                                <div class="rounded-xl border-4 border-dark-ink bg-retro-cream px-4 py-4 shadow-[2px_2px_0px_#0f172a]">
                                    <p class="text-xs font-black uppercase tracking-wide text-dark-ink/70">Area Layanan</p>
                                    <p class="mt-1 text-base font-black text-slate-950">Wonosobo - Magelang - Purwokerto</p>
                                </div>
                                <div class="rounded-xl border-4 border-dark-ink bg-blue-50 px-4 py-4 shadow-[2px_2px_0px_#0f172a]">
                                    <p class="text-xs font-black uppercase tracking-wide text-dark-ink/70">Instagram</p>
                                    <a href="https://www.instagram.com/missiprivatecourse?igsh=bXRqOGpleWxrYWJ5" target="_blank" class="mt-1 inline-flex text-base font-black text-electric-blue hover:text-vivid-amberDark hover:underline">
                                        @missiprivatecourse
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="cara-kerja" class="bg-grid-pattern py-20 sm:py-28 bg-slate-100/40">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-3xl text-center">
                    <p class="section-kicker">Cara Memulai</p>
                    <h2 class="mt-3 text-3xl font-black leading-tight text-slate-950 sm:text-4xl font-display tracking-tight">Mulai Belajar Bersama Kami</h2>
                </div>
                <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach([
                        ['1', 'Konsultasikan kebutuhan siswa', 'Sampaikan jenjang, mata pelajaran, lokasi, jadwal, dan kebutuhan anak.', 'bg-electric-blue'],
                        ['2', 'Kami mencarikan tutor', 'Tutor dipilih berdasarkan kompetensi, lokasi, jadwal, dan karakter kebutuhan siswa.', 'bg-neon-pink'],
                        ['3', 'Mulai belajar', 'Tutor dan orang tua menyepakati jadwal serta sistem pembelajaran.', 'bg-vivid-amber'],
                        ['4', 'Pantau perkembangan', 'Orang tua menerima laporan kegiatan dan perkembangan belajar.', 'bg-acid-lime'],
                    ] as $step)
                        <article class="relative rounded-2xl border-4 border-dark-ink bg-white p-6 brutal-shadow transition-transform hover:-translate-y-1">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full border-4 border-dark-ink {{ $step[3] ?? 'bg-electric-blue' }} text-xl font-black text-dark-ink shadow-[2px_2px_0px_#0f172a]">{{ $step[0] }}</div>
                            <h3 class="mt-5 text-lg font-black leading-tight text-slate-950 font-display">{{ $step[1] }}</h3>
                            <div class="mt-3 h-1.5 w-10 bg-dark-ink"></div>
                            <p class="mt-3 text-sm font-semibold leading-7 text-slate-700">{{ $step[2] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="laporan" class="bg-white py-16 sm:py-20">
            <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
                <div>
                    <p class="section-kicker">Informasi Laporan Belajar</p>
                    <h2 class="mt-3 text-3xl font-black leading-tight text-slate-950 sm:text-4xl font-display tracking-tight">Missi Memiliki Sistem untuk Mencatat Perkembangan Siswa</h2>
                    <p class="mt-5 text-base leading-8 text-slate-600">
                        Dalam layanan Missi, sesi belajar dapat dicatat melalui sistem laporan. Informasi ini membantu orang tua mengetahui materi yang dipelajari, catatan tutor, tingkat pemahaman, dan dokumentasi kegiatan jika tersedia.
                    </p>
                    <p class="mt-4 text-base leading-8 text-slate-600">
                        Laporan dapat dibuka melalui link resmi ketika sudah tersedia, sehingga orang tua punya referensi perkembangan belajar anak dari waktu ke waktu.
                    </p>
                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        @foreach(['Materi tiap pertemuan', 'Catatan tutor untuk orang tua', 'Skor pemahaman siswa', 'Foto dokumentasi jika tersedia'] as $reportPoint)
                            <div class="rounded-xl border-4 border-dark-ink bg-white p-4 text-sm font-black text-electric-blue brutal-shadow transition-transform hover:-translate-y-1">{{ $reportPoint }}</div>
                        @endforeach
                    </div>
                    <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring mt-7 inline-flex rounded-xl border-2 border-dark-ink bg-electric-blue px-6 py-3 text-sm font-black text-white brutal-shadow brutal-shadow-hover">
                        Tanya Alur Laporan Belajar
                    </a>
                </div>
                <div class="rounded-3xl border-4 border-dark-ink bg-dark-ink p-4 sm:p-6 brutal-shadow">
                    <div class="rounded-2xl border-4 border-dark-ink bg-white p-5">
                        <div class="flex items-center justify-between border-b-4 border-dark-ink pb-4">
                            <div>
                                <p class="inline-block bg-vivid-amber px-2 py-1 text-xs font-black uppercase tracking-widest text-dark-ink font-mono border-2 border-dark-ink shadow-[2px_2px_0px_#0f172a]">Contoh Informasi</p>
                                <p class="mt-3 text-lg font-black text-slate-950 font-display">Laporan Perkembangan Siswa</p>
                            </div>
                            <span class="rounded-full border-2 border-dark-ink bg-retro-cream px-3 py-1 text-xs font-black text-dark-ink shadow-[2px_2px_0px_#0f172a]">Online</span>
                        </div>
                        <div class="mt-5 grid gap-4">
                            <div class="rounded-xl border-4 border-dark-ink bg-slate-50 p-4">
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <p class="text-sm font-black text-slate-950">Selasa, 02 Juni 2026</p>
                                    <span class="rounded-full border-2 border-dark-ink bg-white px-3 py-1 text-xs font-black text-electric-blue shadow-[2px_2px_0px_#0f172a]">Matematika</span>
                                </div>
                                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                    <div>
                                        <p class="text-xs font-black uppercase text-slate-500 font-mono">Materi</p>
                                        <p class="mt-1 text-sm font-bold leading-6 text-slate-800">Latihan operasi hitung dan soal cerita.</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black uppercase text-slate-500 font-mono">Catatan Tutor</p>
                                        <p class="mt-1 text-sm font-bold leading-6 text-slate-800">Anak mulai percaya diri, perlu latihan rutin.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-xl border-4 border-dark-ink bg-white p-4">
                                    <p class="text-xs font-black uppercase text-slate-500 font-mono">Pemahaman</p>
                                    <p class="mt-1 text-2xl font-black text-electric-blue">5 / 5</p>
                                    <p class="mt-1 text-xs font-bold text-slate-500">Dicatat per sesi</p>
                                </div>
                                <div class="rounded-xl border-4 border-dark-ink bg-white p-4">
                                    <p class="text-xs font-black uppercase text-slate-500 font-mono">Dokumentasi</p>
                                    <div class="mt-2 grid grid-cols-3 gap-2">
                                        <div class="h-10 rounded-lg border-2 border-dark-ink bg-blue-50"></div>
                                        <div class="h-10 rounded-lg border-2 border-dark-ink bg-retro-cream"></div>
                                        <div class="h-10 rounded-lg border-2 border-dark-ink bg-yellow-50"></div>
                                    </div>
                                    <p class="mt-2 text-xs font-bold text-slate-500">Foto sesi jika tersedia</p>
                                </div>
                            </div>
                            <div class="rounded-xl border-4 border-dark-ink bg-retro-cream p-4">
                                <p class="inline-block bg-white px-2 py-1 text-xs font-black uppercase text-dark-ink font-mono border-2 border-dark-ink shadow-[2px_2px_0px_#0f172a]">Untuk Orang Tua</p>
                                <p class="mt-3 text-sm font-bold leading-6 text-slate-800">Orang tua mendapat gambaran kegiatan belajar anak melalui catatan yang tersimpan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="tutor" class="bg-blue-50 py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <p class="section-kicker">Tutor</p>
                        <h2 class="mt-3 text-3xl font-black leading-tight text-slate-950 sm:text-4xl font-display tracking-tight">Tutor yang Ramah, Terpercaya, dan Terseleksi</h2>
                        <p class="mt-5 text-base leading-8 text-slate-600">Beberapa tutor aktif Missi. Admin akan membantu mencocokkan tutor dengan kebutuhan, karakter, dan jadwal belajar anak.</p>
                    </div>
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('tutors.public.index') }}" class="focus-ring inline-flex rounded-xl border-2 border-dark-ink bg-white px-6 py-3 text-sm font-black text-electric-blue brutal-shadow brutal-shadow-hover transition hover:bg-retro-cream">
                            Lihat Tutor Lainnya
                        </a>
                        <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring inline-flex rounded-xl border-2 border-dark-ink bg-electric-blue px-6 py-3 text-sm font-black text-white brutal-shadow brutal-shadow-hover transition hover:bg-dark-ink">
                            Konsultasi Tutor yang Cocok
                        </a>
                    </div>
                </div>
            </div>

            @if(($landingTutors ?? collect())->isNotEmpty())
                <div class="mt-10 w-full overflow-hidden">
                    <div class="flex gap-5 overflow-x-auto pb-10 pt-4 px-4 sm:px-6 snap-x snap-mandatory scrollbar-hide" style="-webkit-overflow-scrolling: touch;">
                        @foreach($landingTutors as $tutor)
                            <div class="w-[280px] shrink-0 snap-center sm:w-[300px]">
                                @include('partials.public-tutor-card', ['tutor' => $tutor])
                            </div>
                        @endforeach
                        <!-- Spacer to allow last card to be fully visible and snap properly -->
                        <div class="w-4 shrink-0 sm:w-6 lg:w-8"></div>
                    </div>
                </div>
            @else
                <div class="mx-auto mt-10 max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach(['Tutor dipilih sesuai kebutuhan anak', 'Bidang belajar disesuaikan dengan program', 'Admin membantu koordinasi jadwal'] as $process)
                            <div class="rounded-xl border-4 border-dark-ink bg-white p-5 brutal-shadow transition-transform hover:-translate-y-1">
                                <p class="font-black leading-7 text-slate-800">{{ $process }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </section>

        <section id="testimoni" class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <p class="section-kicker">Cerita Orang Tua</p>
                    <h2 class="mt-3 text-3xl font-black leading-tight text-slate-950 sm:text-4xl font-display tracking-tight">Testimoni Orang Tua</h2>
                    <p class="mt-4 text-base leading-8 text-slate-600">Testimoni publik akan ditampilkan setelah mendapatkan izin publikasi dari orang tua siswa.</p>
                </div>
                <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach([['Testimoni program Calistung', 'bg-electric-blue'], ['Testimoni les mapel sekolah', 'bg-neon-pink'], ['Testimoni bahasa Inggris atau program lain', 'bg-vivid-amber']] as $testimonial)
                        <div class="relative rounded-2xl border-4 border-dark-ink bg-white p-6 brutal-shadow transition-transform hover:-translate-y-1">
                            <div class="absolute -right-3 -top-3 h-8 w-8 rounded-full border-2 border-dark-ink {{ $testimonial[1] }} shadow-[2px_2px_0px_#0f172a]"></div>
                            <p class="text-base font-black text-slate-950 font-display">{{ $testimonial[0] }}</p>
                            <div class="mt-3 h-1 w-12 bg-dark-ink"></div>
                            <p class="mt-3 text-sm font-bold leading-7 text-slate-600">[Menunggu testimoni asli dan izin publikasi]</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="area" class="bg-retro-cream py-16 sm:py-20">
            <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
                <div>
                    <p class="inline-block bg-dark-ink px-2 py-1 text-xs font-black uppercase tracking-widest text-retro-cream font-mono">Area Layanan</p>
                    <h2 class="mt-4 text-3xl font-black leading-tight text-slate-950 sm:text-4xl font-display tracking-tight">Area Layanan Tutor Bimbel Missi</h2>
                    <p class="mt-5 text-base font-bold leading-8 text-slate-700">
                        Layanan Bimbel Missi saat ini mencakup area Wonosobo, Magelang, dan Purwokerto.
                    </p>
                    <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring mt-7 inline-flex rounded-xl border-2 border-dark-ink bg-electric-blue px-6 py-3 text-sm font-black text-white brutal-shadow brutal-shadow-hover transition">
                        Cek Ketersediaan Tutor di Lokasi Saya
                    </a>
                </div>
                <div class="rounded-3xl border-4 border-dark-ink bg-white p-6 brutal-shadow sm:p-8">
                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach([['Wonosobo', 'bg-vivid-amber'], ['Magelang', 'bg-neon-pink'], ['Purwokerto', 'bg-acid-lime']] as $area)
                            <div class="rounded-xl border-4 border-dark-ink {{ $area[1] }} p-4 text-center text-sm font-black text-dark-ink shadow-[2px_2px_0px_#0f172a] transition-transform hover:-translate-y-1">{{ $area[0] }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section id="faq" class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="section-kicker">FAQ</p>
                    <h2 class="mt-3 text-3xl font-black leading-tight text-slate-950 sm:text-4xl font-display tracking-tight">Pertanyaan yang Sering Ditanyakan</h2>
                </div>
                <div class="mt-10 space-y-4">
                    @foreach($faqItems as $faq)
                        <details class="group rounded-2xl border-4 border-dark-ink bg-white p-5 brutal-shadow transition-all hover:brutal-shadow-hover hover:-translate-y-1">
                            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-left font-black text-slate-950">
                                {{ $faq['q'] }}
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border-2 border-dark-ink bg-vivid-amber text-xl font-black text-dark-ink shadow-[2px_2px_0px_#0f172a] transition-transform duration-300 group-open:rotate-45 group-open:bg-neon-pink group-open:text-white">+</span>
                            </summary>
                            <div class="mt-4 border-t-2 border-dark-ink pt-4">
                                <p class="text-sm font-bold leading-7 text-slate-700">{{ $faq['a'] }}</p>
                            </div>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="kontak" class="bg-electric-blue py-16 text-white sm:py-20">
            <div class="mx-auto max-w-5xl px-4 text-center sm:px-6 lg:px-8">
                <p class="section-kicker text-acid-lime">Konsultasi Gratis</p>
                <h2 class="mt-3 text-3xl font-black leading-tight sm:text-4xl font-display tracking-tight">Yuk, Temukan Program Belajar yang Cocok untuk Anak Anda</h2>
                <p class="mx-auto mt-5 max-w-2xl text-base leading-8 text-retro-cream">Ceritakan kebutuhan anak kepada kami. Tim Bimbel Missi akan membantu mencarikan program dan tutor yang sesuai.</p>
                <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                    <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring inline-flex justify-center rounded-xl border-2 border-dark-ink brutal-shadow brutal-shadow-hover bg-vivid-amber px-7 py-4 text-base font-black text-dark-ink">Konsultasi Gratis via WhatsApp</a>
                    <a href="{{ $formUrl }}" target="_blank" class="focus-ring inline-flex justify-center rounded-xl border-2 border-dark-ink brutal-shadow brutal-shadow-hover bg-white px-7 py-4 text-base font-black text-electric-blue">Isi Formulir Online</a>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-slate-950 py-12 text-slate-300">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 md:grid-cols-4 lg:px-8">
            <div class="md:col-span-2">
                <img src="{{ asset('images/logo1.png') }}" alt="Logo Bimbel Missi" class="h-14 w-14 rounded-full border-[2px] border-dark-ink object-cover">
                <p class="mt-4 max-w-md text-sm leading-7 text-slate-400">Bimbel Missi membantu orang tua menemukan pendamping belajar yang lebih personal untuk anak, dengan layanan privat ke rumah dan laporan perkembangan.</p>
            </div>
            <div>
                <p class="font-black text-white">Navigasi</p>
                <div class="mt-4 grid gap-2 text-sm">
                    <a href="#program" class="hover:text-white">Program</a>
                    <a href="#harga" class="hover:text-white">Harga</a>
                    <a href="#cara-kerja" class="hover:text-white">Cara Kerja</a>
                    <a href="#laporan" class="hover:text-white">Laporan</a>
                    <a href="#faq" class="hover:text-white">FAQ</a>
                </div>
            </div>
            <div>
                <p class="font-black text-white">Kontak</p>
                <div class="mt-4 grid gap-2 text-sm">
                    <a href="{{ $whatsappUrl }}" target="_blank" class="hover:text-white">WhatsApp Admin</a>
                    <a href="https://www.instagram.com/missiprivatecourse?igsh=bXRqOGpleWxrYWJ5" target="_blank" class="hover:text-white">Instagram</a>
                    <span>Wonosobo, Magelang, dan Purwokerto</span>
                </div>
            </div>
        </div>
        <div class="mx-auto mt-10 flex max-w-7xl flex-col gap-3 border-t border-slate-800 px-4 pt-6 text-sm text-slate-500 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
            <p>&copy; {{ now()->year }} Bimbel Missi. All rights reserved.</p>
            <p>Data testimoni, profil tutor, harga publik, dan video hero dapat ditambahkan saat aset resmi tersedia.</p>
        </div>
    </footer>

    <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring fixed bottom-4 right-4 z-40 inline-flex items-center justify-center rounded-xl border-2 border-dark-ink brutal-shadow brutal-shadow-hover bg-vivid-amber px-5 py-4 text-sm font-black text-dark-ink">
        WhatsApp
    </a>

    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const navOffset = 92;
        let activeScrollAnimation = null;

        const easeInOutCubic = (progress) => {
            return progress < 0.5
                ? 4 * progress * progress * progress
                : 1 - Math.pow(-2 * progress + 2, 3) / 2;
        };

        const animateScrollTo = (targetTop, duration = 950) => {
            const startTop = window.pageYOffset;
            const distance = targetTop - startTop;
            const startTime = performance.now();
            if (activeScrollAnimation) { cancelAnimationFrame(activeScrollAnimation); }
            const step = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const eased = easeInOutCubic(progress);
                window.scrollTo(0, startTop + distance * eased);
                if (progress < 1) {
                    activeScrollAnimation = requestAnimationFrame(step);
                } else {
                    activeScrollAnimation = null;
                }
            };
            activeScrollAnimation = requestAnimationFrame(step);
        };

        btn?.addEventListener('click', () => { menu?.classList.toggle('hidden'); });
        menu?.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => menu.classList.add('hidden'));
        });

        document.querySelectorAll('a[href^="#"]').forEach((link) => {
            link.addEventListener('click', (event) => {
                const targetId = link.getAttribute('href');
                if (!targetId || targetId === '#') return;
                const target = document.querySelector(targetId);
                if (!target) return;
                event.preventDefault();
                const targetTop = target.getBoundingClientRect().top + window.pageYOffset - navOffset;
                animateScrollTo(Math.max(targetTop, 0));
                history.pushState(null, '', targetId);
            });
        });

        const statsSection = document.getElementById('landing-stats');
        const statValues = document.querySelectorAll('.landing-stat-value');
        const numberFormatter = new Intl.NumberFormat('id-ID');

        const animateStatValue = (element) => {
            if (element.dataset.counted === 'true') return;
            const target = Number(element.dataset.countupTarget || '0');
            const suffix = element.dataset.countupSuffix || '';
            const duration = 1400;
            const startTime = performance.now();
            const updateValue = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                const currentValue = Math.round(target * eased);
                element.textContent = `${numberFormatter.format(currentValue)}${suffix}`;
                if (progress < 1) {
                    requestAnimationFrame(updateValue);
                } else {
                    element.textContent = `${numberFormatter.format(target)}${suffix}`;
                    element.dataset.counted = 'true';
                }
            };
            requestAnimationFrame(updateValue);
        };

        if (statsSection && statValues.length > 0) {
            const statsObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    statValues.forEach((element) => animateStatValue(element));
                    observer.disconnect();
                });
            }, { threshold: 0.35 });
            statsObserver.observe(statsSection);
        }
    </script>
</body>
</html>
