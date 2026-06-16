@php
    $whatsappNumber = '62895392551182';
    $whatsappMessage = "Halo Admin Bimbel Missi, saya ingin bertanya dan berkonsultasi mengenai les privat.";
    $whatsappUrl = 'https://wa.me/' . $whatsappNumber . '?text=' . urlencode($whatsappMessage);
    $formUrl = 'https://docs.google.com/forms/d/e/1FAIpQLSe56xKm0Gpq36OrtELzSy2VMTcZMYqee2os50e4JcZWestU6g/viewform?usp=publish-editor';
    $heroVideoExists = file_exists(public_path('videos/hero-belajar.mp4'));
    $canonicalUrl = url('/');
    $ogImage = asset('images/Profil1.jpeg');
    $programs = [
        ['title' => 'Privat Calistung', 'category' => 'Usia dini', 'goal' => 'Membantu anak membaca, menulis, dan berhitung dengan cara yang menyenangkan.', 'mode' => 'Tutor datang ke rumah', 'cta' => 'Tanya Program Calistung', 'tone' => 'bg-miss-cream text-miss-goldDark border-miss-gold/20'],
        ['title' => 'Les Mapel SD', 'category' => 'Sekolah dasar', 'goal' => 'Pendampingan PR, latihan soal, dan penguatan materi sekolah.', 'mode' => 'Tutor datang ke rumah', 'cta' => 'Konsultasi Les SD', 'tone' => 'bg-miss-blueSoft text-miss-navy border-miss-navy/10'],
        ['title' => 'Les SMP dan SMA', 'category' => 'Sekolah menengah', 'goal' => 'Belajar lebih terarah untuk mapel inti dan persiapan evaluasi sekolah.', 'mode' => 'Tutor datang ke rumah atau online', 'cta' => 'Cari Tutor Mapel', 'tone' => 'bg-miss-blueSoft text-miss-navyDark border-miss-navy/10'],
        ['title' => 'Bahasa Inggris', 'category' => 'Bahasa', 'goal' => 'Meningkatkan vocabulary, speaking, grammar, dan percaya diri berbahasa.', 'mode' => 'Privat atau kelompok kecil', 'cta' => 'Cari Tutor Bahasa Inggris', 'tone' => 'bg-miss-sand text-miss-goldDark border-miss-gold/20'],
        ['title' => 'Mengaji', 'category' => 'Keagamaan', 'goal' => "Bimbingan baca tulis Al-Qur'an dengan pendampingan yang sabar.", 'mode' => 'Tutor datang ke rumah', 'cta' => 'Tanya Program Mengaji', 'tone' => 'bg-miss-cream text-miss-goldDark border-miss-gold/20'],
        ['title' => 'Kreatif Menggambar', 'category' => 'Kreativitas', 'goal' => 'Mengasah motorik halus, ekspresi, dan kreativitas anak.', 'mode' => 'Privat atau kelompok kecil', 'cta' => 'Tanya Kelas Kreatif', 'tone' => 'bg-miss-blueSoft text-miss-navy border-miss-navy/10'],
        ['title' => 'Persiapan Ujian', 'category' => 'Tes dan evaluasi', 'goal' => 'Latihan soal dan review materi untuk menghadapi ujian dengan lebih siap.', 'mode' => 'Tutor datang ke rumah atau online', 'cta' => 'Cek Program Ujian', 'tone' => 'bg-miss-sand text-miss-goldDark border-miss-gold/20'],
        ['title' => 'Privat Renang', 'category' => 'Skill anak', 'goal' => 'Latihan renang dasar sampai mahir bersama instruktur.', 'mode' => 'Lokasi menyesuaikan', 'cta' => 'Cek Jadwal Renang', 'tone' => 'bg-miss-blueSoft text-miss-navyDark border-miss-navy/10'],
    ];
    $faqItems = [
        ['q' => 'Apakah tutor datang ke rumah?', 'a' => 'Ya, layanan utama Bimbel Missi adalah les privat ke rumah. Untuk beberapa program, pembelajaran online atau lokasi khusus dapat menyesuaikan kebutuhan.'],
        ['q' => 'Apakah jadwal belajar dapat dipilih?', 'a' => 'Jadwal dapat dikonsultasikan terlebih dahulu. Admin akan membantu menyesuaikan kebutuhan orang tua, siswa, dan ketersediaan tutor.'],
        ['q' => 'Berapa biaya les privat?', 'a' => 'Biaya disesuaikan dengan jenjang, program, lokasi, dan jumlah pertemuan. Konsultasi kebutuhan dan pencarian tutor tidak dikenakan biaya.'],
        ['q' => 'Apakah tutor dapat diganti?', 'a' => 'Jika ada kendala kecocokan atau jadwal, orang tua dapat berkonsultasi dengan admin agar dicari solusi sesuai kebijakan layanan.'],
        ['q' => 'Apakah tersedia pembelajaran online?', 'a' => 'Beberapa program dapat dilakukan secara online, terutama bahasa Inggris, speaking, TOEFL, atau pendampingan mapel tertentu.'],
        ['q' => 'Apakah orang tua menerima laporan belajar?', 'a' => 'Ya. Orang tua dapat memantau materi yang dipelajari, catatan tutor, pemahaman siswa, dan dokumentasi kegiatan jika tersedia.'],
        ['q' => 'Area mana saja yang dilayani?', 'a' => 'Saat ini layanan masih berfokus di area Wonosobo dan sekitarnya. Ke depannya Bimbel Missi berencana membuka layanan untuk daerah lain secara bertahap.'],
        ['q' => 'Bagaimana cara mendaftar?', 'a' => 'Klik tombol Konsultasi Gratis, isi kebutuhan belajar anak, lalu admin akan membantu mencarikan program dan tutor yang sesuai.'],
    ];
@endphp
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Privat ke Rumah untuk Anak | Bimbel Missi</title>
    <meta name="description" content="Bimbel Missi menyediakan tutor privat ke rumah untuk Calistung, SD, SMP, SMA, Bahasa Inggris, Mengaji, Renang, dan persiapan ujian. Saat ini fokus area Wonosobo dan sekitarnya, dengan rencana ekspansi bertahap.">
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
                            sand: '#f8f2e9',
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
            background: rgba(255, 255, 255, .86);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(226, 232, 240, .8);
        }
        .soft-section {
            background:
                linear-gradient(180deg, rgba(255,255,255,.94), rgba(237,246,251,.72)),
                #ffffff;
        }
        .hero-pattern {
            background:
                linear-gradient(115deg, rgba(237,246,251,.98) 0%, rgba(255,248,237,.94) 48%, rgba(248,242,233,.88) 100%);
        }
        .hero-pattern::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .78;
            background-image:
                linear-gradient(118deg, transparent 0 56%, rgba(194,133,82,.16) 56% 70%, transparent 70%),
                linear-gradient(90deg, rgba(32,80,133,.075) 1px, transparent 1px),
                linear-gradient(0deg, rgba(32,80,133,.055) 1px, transparent 1px);
            background-size: auto, 48px 48px, 48px 48px;
            mask-image: linear-gradient(90deg, rgba(0,0,0,.7), rgba(0,0,0,.18) 46%, rgba(0,0,0,.82));
        }
        .brand-ring {
            position: absolute;
            pointer-events: none;
            border-radius: 9999px;
            border: 2px solid rgba(32,80,133,.16);
        }
        .brand-ring::before,
        .brand-ring::after {
            content: "";
            position: absolute;
            inset: 18%;
            border-radius: inherit;
            border: 2px solid currentColor;
        }
        .brand-ring::after {
            inset: 36%;
        }
        .hero-ring-left {
            left: -170px;
            top: 150px;
            width: 340px;
            height: 340px;
            color: rgba(194,133,82,.18);
        }
        .hero-ring-right {
            right: -210px;
            top: 112px;
            width: 460px;
            height: 460px;
            color: rgba(32,80,133,.14);
            border-color: rgba(194,133,82,.2);
        }
        .media-accent::before {
            content: "";
            position: absolute;
            right: -22px;
            top: 34px;
            width: 72%;
            height: 74%;
            border-radius: 9999px;
            border: 20px solid rgba(194,133,82,.16);
            transform: rotate(-10deg);
            z-index: 0;
        }
        .feature-pill {
            display: flex;
            align-items: center;
            gap: .55rem;
            border-radius: 9999px;
            border: 1px solid rgba(32,80,133,.1);
            background: rgba(255,255,255,.78);
            padding: .7rem .9rem;
            box-shadow: 0 10px 28px rgba(15,23,42,.06);
        }
        .feature-pill::before {
            content: "";
            width: .48rem;
            height: .48rem;
            flex: 0 0 auto;
            border-radius: 9999px;
            background: #c28552;
        }
        .quiet-strip {
            position: relative;
            overflow: hidden;
            background: rgba(255,255,255,.9);
            box-shadow: 0 22px 54px rgba(15,23,42,.08);
        }
        .quiet-strip::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: linear-gradient(90deg, rgba(32,80,133,.08), transparent 32%, rgba(194,133,82,.12));
        }
        .story-section {
            position: relative;
            overflow: hidden;
            background:
                linear-gradient(112deg, #fffaf1 0%, #ffffff 46%, #edf6fb 100%);
        }
        .story-section::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .52;
            background-image:
                linear-gradient(90deg, rgba(32,80,133,.055) 1px, transparent 1px),
                linear-gradient(0deg, rgba(32,80,133,.04) 1px, transparent 1px);
            background-size: 44px 44px;
            mask-image: linear-gradient(180deg, rgba(0,0,0,.7), rgba(0,0,0,.1) 78%);
        }
        .story-photo {
            position: relative;
            overflow: hidden;
            box-shadow: 0 24px 70px rgba(15,23,42,.16);
        }
        .story-photo::after {
            content: "";
            position: absolute;
            inset: auto 0 0;
            height: 34%;
            background: linear-gradient(180deg, transparent, rgba(15,23,42,.72));
        }
        .handline {
            position: relative;
            display: inline;
        }
        .handline::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: .08em;
            height: .28em;
            z-index: -1;
            background: rgba(194,133,82,.22);
        }
        .natural-list-item {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 1rem;
            align-items: start;
            padding-block: 1.15rem;
            border-bottom: 1px solid rgba(32,80,133,.1);
        }
        .natural-list-item:last-child {
            border-bottom: 0;
        }
        .benefit-index {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 9999px;
            background: #fff8ed;
            color: #b46c43;
            font-size: .78rem;
            font-weight: 900;
        }
        .media-accent::after {
            content: "";
            position: absolute;
            left: 8%;
            bottom: 8%;
            width: 40%;
            height: 30%;
            border-radius: 9999px;
            border: 12px solid rgba(32,80,133,.12);
            transform: rotate(12deg);
            z-index: 0;
        }
        .media-accent > * {
            position: relative;
            z-index: 1;
        }
        .video-card {
            aspect-ratio: 9 / 16;
        }
        .section-kicker {
            color: #b46c43;
            font-size: .78rem;
            font-weight: 900;
            text-transform: uppercase;
        }
        .focus-ring:focus-visible {
            outline: 3px solid rgba(194, 133, 82, .38);
            outline-offset: 4px;
        }
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
            .hero-pattern::before {
                opacity: .45;
                background-size: auto, 28px 28px, 28px 28px;
            }
            .media-accent::before,
            .media-accent::after {
                display: none;
            }
            .video-card {
                aspect-ratio: 5 / 7;
            }
        }
    </style>

    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => ['LocalBusiness', 'EducationalOrganization'],
            'name' => 'Bimbel Missi',
            'url' => $canonicalUrl,
            'image' => $ogImage,
            'areaServed' => 'Wonosobo dan sekitarnya',
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
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[70] focus:rounded-lg focus:bg-white focus:px-4 focus:py-3 focus:font-bold focus:text-miss-navy">Lewati ke konten</a>

    <nav class="nav-glass fixed inset-x-0 top-0 z-50">
        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="#home" class="focus-ring flex items-center gap-3 rounded-lg" aria-label="Bimbel Missi">
                <img src="{{ asset('images/logo1.png') }}" alt="Logo Bimbel Missi" class="h-11 w-auto">
                <span class="hidden text-base font-black text-miss-navy sm:block">Missi Private Course</span>
            </a>

            <div class="hidden items-center gap-7 text-sm font-bold text-slate-700 lg:flex">
                <a class="hover:text-miss-navy" href="#home">Beranda</a>
                <a class="hover:text-miss-navy" href="#program">Program</a>
                <a class="hover:text-miss-navy" href="#cara-kerja">Cara Kerja</a>
                <a class="hover:text-miss-navy" href="#laporan">Laporan</a>
                <a class="hover:text-miss-navy" href="#tutor">Tutor</a>
                <a class="hover:text-miss-navy" href="#faq">FAQ</a>
            </div>

            <div class="hidden items-center gap-3 lg:flex">
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

            <button id="mobile-menu-btn" type="button" class="focus-ring inline-flex h-11 w-11 items-center justify-center rounded-lg border border-slate-200 bg-white text-miss-navy lg:hidden" aria-label="Buka menu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
            </button>
        </div>

        <div id="mobile-menu" class="hidden border-t border-slate-100 bg-white px-4 py-4 shadow-lg lg:hidden">
            <div class="grid gap-2 text-sm font-bold text-slate-700">
                <a class="rounded-lg px-3 py-2 hover:bg-miss-blueSoft" href="#home">Beranda</a>
                <a class="rounded-lg px-3 py-2 hover:bg-miss-blueSoft" href="#program">Program</a>
                <a class="rounded-lg px-3 py-2 hover:bg-miss-blueSoft" href="#cara-kerja">Cara Kerja</a>
                <a class="rounded-lg px-3 py-2 hover:bg-miss-blueSoft" href="#laporan">Laporan</a>
                <a class="rounded-lg px-3 py-2 hover:bg-miss-blueSoft" href="#tutor">Tutor</a>
                <a class="rounded-lg px-3 py-2 hover:bg-miss-blueSoft" href="#faq">FAQ</a>
                @auth
                    <a class="rounded-lg px-3 py-2 hover:bg-miss-blueSoft" href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a class="rounded-lg px-3 py-2 hover:bg-miss-blueSoft" href="{{ route('login') }}">Login Portal</a>
                @endauth
                <a class="mt-2 rounded-lg bg-miss-gold px-4 py-3 text-center font-black text-white" href="{{ $whatsappUrl }}" target="_blank">Konsultasi Gratis</a>
            </div>
        </div>
    </nav>

    <main id="main-content">
        <section id="home" class="hero-pattern relative overflow-hidden pt-16 sm:pt-16 lg:pt-20">
            <div class="brand-ring hero-ring-left hidden lg:block" aria-hidden="true"></div>
            <div class="brand-ring hero-ring-right hidden lg:block" aria-hidden="true"></div>
            <div class="relative z-10 mx-auto grid min-h-[auto] max-w-7xl items-center gap-10 px-4 pt-10 pb-14 sm:px-6 sm:pt-12 sm:pb-16 lg:min-h-[680px] lg:grid-cols-[.9fr_1.1fr] lg:gap-12 lg:px-8 lg:pt-16 lg:pb-24 xl:gap-16">
                <div class="max-w-2xl pt-3 sm:pt-4 lg:pt-2">
                    <p class="mb-5 inline-flex rounded-full border border-miss-navy/10 bg-white/80 px-4 py-2 text-sm font-extrabold text-miss-navy shadow-sm">
                        Pendaftaran Tahun Ajaran 2026/2027 Dibuka
                    </p>
                    <h1 class="max-w-3xl text-[2.85rem] font-black leading-[.96] text-slate-950 sm:text-5xl sm:leading-tight lg:text-6xl xl:text-[4.3rem]">
                        Les Privat ke Rumah untuk Anak
                    </h1>
                    <p class="mt-5 max-w-2xl text-[1rem] font-semibold leading-7 text-slate-600 sm:mt-6 sm:text-lg sm:leading-8">
                        Bimbel Missi membantu anak belajar dengan tutor yang ramah, jadwal fleksibel, materi personal, serta didukung sistem untuk mencatat laporan perkembangan belajar.
                    </p>
                    <div class="mt-8 flex max-w-xl flex-col gap-3 sm:flex-row">
                        <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring inline-flex min-h-14 flex-1 items-center justify-center rounded-full bg-miss-gold px-6 py-3 text-center text-base font-black text-white shadow-xl shadow-slate-950/10 transition hover:bg-miss-goldDark sm:text-sm sm:whitespace-nowrap">
                            Konsultasi Gratis via WhatsApp
                        </a>
                        <a href="#laporan" class="focus-ring inline-flex min-h-14 flex-1 items-center justify-center rounded-full border border-slate-200 bg-white px-6 py-3 text-center text-base font-black text-miss-navy shadow-xl shadow-slate-950/10 transition hover:bg-miss-blueSoft sm:text-sm sm:whitespace-nowrap">
                            Lihat Laporan Belajar
                        </a>
                    </div>
                    <div class="mt-8 grid max-w-2xl gap-3 text-sm font-black text-slate-700 sm:flex sm:flex-wrap">
                        <span class="feature-pill">Tutor datang ke rumah</span>
                        <span class="feature-pill">Jadwal fleksibel</span>
                        <span class="feature-pill">Ada laporan belajar</span>
                        <span class="feature-pill">Fokus Wonosobo, soon area lain</span>
                    </div>
                </div>

                <div class="media-accent relative mx-auto w-full max-w-[620px] pt-2 lg:pt-8">
                    <div class="relative mx-auto grid max-w-[560px] items-start gap-4 sm:gap-5 md:grid-cols-[minmax(0,.9fr)_minmax(0,1.15fr)]">
                        <div class="relative z-10 order-2 space-y-4 md:order-1">
                            <div class="overflow-hidden rounded-lg border-4 border-white bg-white shadow-xl">
                                <img src="{{ asset('images/Profile2.jpeg') }}" alt="Anak mengerjakan latihan bersama Bimbel Missi" class="h-44 w-full object-cover sm:h-56" loading="eager">
                            </div>
                            <div class="rounded-lg border border-miss-gold/20 bg-white/95 p-4 shadow-xl">
                                <p class="text-xs font-black uppercase text-miss-gold">Belajar personal</p>
                                <p class="mt-1 text-sm font-black leading-6 text-slate-900">Materi dan tempo belajar disesuaikan dengan anak.</p>
                            </div>
                        </div>

                        <div class="relative z-20 order-1 pb-0 md:order-2 md:pb-8">
                            <div class="video-card overflow-hidden rounded-lg border-[9px] border-slate-950 bg-slate-950 shadow-2xl shadow-slate-900/20">
                                @if($heroVideoExists)
                                    <video class="hero-video h-full w-full object-cover" autoplay muted loop playsinline poster="{{ asset('images/Profil1.jpeg') }}">
                                        <source src="{{ asset('videos/hero-belajar.mp4') }}" type="video/mp4">
                                    </video>
                                    <img src="{{ asset('images/Profil1.jpeg') }}" alt="Video kegiatan belajar Bimbel Missi" class="hidden h-full w-full object-cover motion-reduce:block">
                                @else
                                    <img src="{{ asset('images/Profil1.jpeg') }}" alt="Kegiatan belajar anak bersama tutor Bimbel Missi" class="h-full w-full object-cover">
                                @endif
                            </div>
                            <div class="mt-4 rounded-lg border border-miss-gold/20 bg-white p-4 shadow-xl md:absolute md:-bottom-6 md:left-1/2 md:mt-0 md:w-[92%] md:-translate-x-1/2">
                                <p class="text-xs font-black uppercase text-miss-gold">Laporan perkembangan</p>
                                <p class="mt-1 text-sm font-bold leading-6 text-slate-700">Orang tua dapat melihat materi, catatan, pemahaman, dan dokumentasi belajar.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="landing-stats" aria-label="Kepercayaan layanan" class="relative z-20 -mt-2 px-4 sm:-mt-10 sm:px-6 lg:px-8">
            <div class="quiet-strip mx-auto rounded-lg border border-white/70">
                <div class="relative mx-auto grid max-w-7xl gap-5 px-5 py-6 sm:px-6 lg:grid-cols-[.85fr_1.15fr] lg:px-8">
                    <div>
                        <p class="text-xs font-black uppercase text-miss-goldDark">Belajar privat yang lebih tertata</p>
                        <p class="mt-2 max-w-xl text-xl font-black leading-8 text-miss-navy">Tutor datang ke rumah, proses belajar dibantu admin, dan laporan sesi dapat dicatat.</p>
                        <p class="mt-3 max-w-xl text-sm leading-7 text-slate-600">Angka di bawah ini diambil dari aktivitas belajar yang sudah tercatat di sistem Missi.</p>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-3">
                        @foreach(($landingStats ?? []) as $stat)
                            <article class="rounded-lg border border-white/80 bg-white/90 p-4 shadow-sm">
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
                    <h2 class="mt-3 max-w-3xl text-3xl font-black leading-tight text-slate-950 sm:text-5xl">
                        Mencari les yang cocok itu seringnya bukan soal <span class="handline">materi saja</span>.
                    </h2>
                    <p class="mt-5 text-base leading-8 text-slate-600">
                        Setiap anak punya ritme belajar yang berbeda. Ada yang butuh pendampingan membaca, ada yang perlu latihan soal, ada juga yang butuh tutor yang sabar dan cocok dengan karakternya.
                    </p>
                    <p class="mt-4 text-base leading-8 text-slate-600">
                        Bimbel Missi membantu mencarikan tutor yang sesuai, mengatur jadwal belajar, dan menyediakan laporan perkembangan agar pembelajaran lebih terarah.
                    </p>
                    <div class="mt-7 grid gap-4 sm:grid-cols-3">
                        <div class="border-l-4 border-miss-gold pl-4">
                            <p class="text-sm font-black text-slate-950">Cocok dengan anak</p>
                            <p class="mt-1 text-sm leading-6 text-slate-600">Tutor dan cara belajar disesuaikan.</p>
                        </div>
                        <div class="border-l-4 border-miss-navy pl-4">
                            <p class="text-sm font-black text-slate-950">Jadwal realistis</p>
                            <p class="mt-1 text-sm leading-6 text-slate-600">Dikonsultasikan dengan keluarga.</p>
                        </div>
                        <div class="border-l-4 border-miss-gold pl-4">
                            <p class="text-sm font-black text-slate-950">Ada catatan belajar</p>
                            <p class="mt-1 text-sm leading-6 text-slate-600">Perkembangan anak lebih mudah dilihat.</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="story-photo rounded-lg">
                        <img src="{{ asset('images/Profile3.jpeg') }}" alt="Kegiatan belajar anak bersama Missi" class="h-[320px] w-full object-cover sm:h-[420px]">
                        <div class="absolute inset-x-0 bottom-0 z-10 p-6 text-white">
                            <p class="text-sm font-black uppercase text-miss-cream">Pendampingan lebih personal</p>
                            <p class="mt-2 max-w-sm text-2xl font-black leading-8">Anak belajar nyaman, orang tua tetap tahu prosesnya.</p>
                        </div>
                    </div>
                    <div class="absolute -left-4 top-6 hidden rounded-lg bg-white p-4 shadow-xl lg:block">
                        <p class="text-xs font-black uppercase text-miss-goldDark">Dibantu admin</p>
                        <p class="mt-1 text-sm font-bold text-slate-700">Mulai dari kebutuhan, tutor, sampai jadwal.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="keunggulan" class="bg-white py-20">
            <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-[.9fr_1.1fr] lg:px-8">
                <div class="lg:sticky lg:top-28 lg:self-start">
                    <p class="section-kicker">Keunggulan</p>
                    <h2 class="mt-3 text-3xl font-black leading-tight text-slate-950 sm:text-5xl">Dibangun untuk keluarga yang butuh pendamping belajar yang pas.</h2>
                    <p class="mt-5 text-base leading-8 text-slate-600">Pendekatannya personal, tetapi tetap dibantu sistem dan admin agar proses belajar lebih tertata.</p>
                    <img src="{{ asset('images/Profile4.jpeg') }}" alt="Dokumentasi kegiatan belajar Missi" class="mt-8 h-64 w-full rounded-lg object-cover shadow-xl">
                </div>
                <div class="divide-y divide-miss-navy/10 rounded-lg border-y border-miss-navy/10">
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
                                <h3 class="text-xl font-black leading-7 text-slate-950">{{ $item[0] }}</h3>
                                <p class="text-base leading-8 text-slate-600">{{ $item[1] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="program" class="bg-miss-cream py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <p class="section-kicker">Pilihan Program</p>
                        <h2 class="mt-3 text-3xl font-black leading-tight text-slate-950 sm:text-4xl">Program Belajar untuk Kebutuhan Anak</h2>
                        <p class="mt-4 text-base leading-8 text-slate-600">Pilih program sesuai usia, jenjang, dan tujuan belajar. Jika masih bingung, admin akan bantu merekomendasikan pilihan yang tepat.</p>
                    </div>
                    <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring inline-flex rounded-full bg-miss-navy px-6 py-3 text-sm font-black text-white hover:bg-miss-navyDark">
                        Konsultasi Program
                    </a>
                </div>

                <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($programs as $program)
                        <article class="rounded-lg border border-slate-100 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                            <span class="inline-flex rounded-full border px-3 py-1 text-xs font-black {{ $program['tone'] }}">{{ $program['category'] }}</span>
                            <h3 class="mt-4 text-lg font-black text-slate-950">{{ $program['title'] }}</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-600">{{ $program['goal'] }}</p>
                            <p class="mt-4 rounded-lg bg-slate-50 px-3 py-2 text-xs font-bold text-slate-600">{{ $program['mode'] }}</p>
                            <a href="{{ $whatsappUrl }}" target="_blank" class="mt-4 inline-flex text-sm font-black text-miss-navy hover:text-miss-gold">{{ $program['cta'] }}</a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="harga" class="bg-white py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="rounded-lg border border-slate-100 bg-slate-950 p-8 text-white lg:flex lg:items-center lg:justify-between lg:p-10">
                    <div class="max-w-3xl">
                        <p class="text-sm font-black uppercase text-miss-gold">Informasi Biaya</p>
                        <h2 class="mt-3 text-2xl font-black sm:text-3xl">Biaya menyesuaikan kebutuhan belajar anak</h2>
                        <p class="mt-4 text-sm leading-7 text-slate-300">
                            Biaya disesuaikan dengan jenjang, program, lokasi, dan jumlah pertemuan. Konsultasi kebutuhan dan pencarian tutor tidak dikenakan biaya.
                        </p>
                    </div>
                    <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring mt-6 inline-flex rounded-full bg-miss-gold px-6 py-3 text-sm font-black text-white hover:bg-miss-goldDark lg:mt-0">
                        Tanya Biaya Les
                    </a>
                </div>
            </div>
        </section>

        <section id="cara-kerja" class="soft-section py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-3xl text-center">
                    <p class="section-kicker">Cara Memulai</p>
                    <h2 class="mt-3 text-3xl font-black leading-tight text-slate-950 sm:text-4xl">Mulai Belajar Bersama Kami</h2>
                </div>
                <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach([
                        ['1', 'Konsultasikan kebutuhan siswa', 'Sampaikan jenjang, mata pelajaran, lokasi, jadwal, dan kebutuhan anak.'],
                        ['2', 'Kami mencarikan tutor', 'Tutor dipilih berdasarkan kompetensi, lokasi, jadwal, dan karakter kebutuhan siswa.'],
                        ['3', 'Mulai belajar', 'Tutor dan orang tua menyepakati jadwal serta sistem pembelajaran.'],
                        ['4', 'Pantau perkembangan', 'Orang tua menerima laporan kegiatan dan perkembangan belajar.'],
                    ] as $step)
                        <article class="rounded-lg border border-slate-100 bg-white p-6 shadow-sm">
                            <div class="flex h-11 w-11 items-center justify-center rounded-full bg-miss-navy text-lg font-black text-white">{{ $step[0] }}</div>
                            <h3 class="mt-5 text-base font-black text-slate-950">{{ $step[1] }}</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-600">{{ $step[2] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="laporan" class="bg-white py-16 sm:py-20">
            <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
                <div>
                    <p class="section-kicker">Informasi Laporan Belajar</p>
                    <h2 class="mt-3 text-3xl font-black leading-tight text-slate-950 sm:text-4xl">Missi Memiliki Sistem untuk Mencatat Perkembangan Siswa</h2>
                    <p class="mt-5 text-base leading-8 text-slate-600">
                        Dalam layanan Missi, sesi belajar dapat dicatat melalui sistem laporan. Informasi ini membantu orang tua mengetahui materi yang dipelajari, catatan tutor, tingkat pemahaman, dan dokumentasi kegiatan jika tersedia.
                    </p>
                    <p class="mt-4 text-base leading-8 text-slate-600">
                        Laporan dapat dibuka melalui link resmi ketika sudah tersedia, sehingga orang tua punya referensi perkembangan belajar anak dari waktu ke waktu.
                    </p>
                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        @foreach(['Materi tiap pertemuan', 'Catatan tutor untuk orang tua', 'Skor pemahaman siswa', 'Foto dokumentasi jika tersedia'] as $reportPoint)
                            <div class="rounded-lg border border-miss-navy/10 bg-miss-blueSoft p-4 text-sm font-bold text-miss-navy">{{ $reportPoint }}</div>
                        @endforeach
                    </div>
                    <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring mt-7 inline-flex rounded-full bg-miss-navy px-6 py-3 text-sm font-black text-white hover:bg-miss-navyDark">
                        Tanya Alur Laporan Belajar
                    </a>
                </div>
                <div class="rounded-lg border border-slate-200 bg-slate-950 p-4 shadow-2xl">
                    <div class="rounded-lg bg-white p-4">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <div>
                                <p class="text-xs font-black uppercase text-miss-gold">Contoh Informasi</p>
                                <p class="mt-1 text-lg font-black text-slate-950">Laporan Perkembangan Siswa</p>
                            </div>
                            <span class="rounded-full bg-miss-cream px-3 py-1 text-xs font-black text-miss-goldDark">Online</span>
                        </div>
                        <div class="mt-4 grid gap-3">
                            <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <p class="text-sm font-black text-slate-950">Selasa, 02 Juni 2026</p>
                                    <span class="rounded-full bg-white px-3 py-1 text-xs font-black text-miss-navy">Matematika</span>
                                </div>
                                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                    <div>
                                        <p class="text-xs font-black uppercase text-slate-400">Materi</p>
                                        <p class="mt-1 text-sm font-bold leading-6 text-slate-700">Latihan operasi hitung dan soal cerita.</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black uppercase text-slate-400">Catatan Tutor</p>
                                        <p class="mt-1 text-sm font-bold leading-6 text-slate-700">Anak mulai percaya diri, perlu latihan rutin.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid gap-3 sm:grid-cols-2">
                                <div class="rounded-lg border border-slate-100 bg-white p-4">
                                    <p class="text-xs font-black uppercase text-slate-400">Pemahaman</p>
                                    <p class="mt-1 text-2xl font-black text-miss-navy">5 / 5</p>
                                    <p class="mt-1 text-xs font-bold text-slate-500">Dicatat per sesi</p>
                                </div>
                                <div class="rounded-lg border border-slate-100 bg-white p-4">
                                    <p class="text-xs font-black uppercase text-slate-400">Dokumentasi</p>
                                    <div class="mt-2 grid grid-cols-3 gap-2">
                                        <div class="h-12 rounded-lg bg-miss-blueSoft"></div>
                                        <div class="h-12 rounded-lg bg-miss-cream"></div>
                                        <div class="h-12 rounded-lg bg-miss-sand"></div>
                                    </div>
                                    <p class="mt-2 text-xs font-bold text-slate-500">Foto sesi jika tersedia</p>
                                </div>
                            </div>
                            <div class="rounded-lg border border-miss-gold/20 bg-miss-cream p-4">
                                <p class="text-xs font-black uppercase text-miss-goldDark">Untuk Orang Tua</p>
                                <p class="mt-1 text-sm font-bold leading-6 text-slate-700">Orang tua mendapat gambaran kegiatan belajar anak melalui catatan yang tersimpan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="tutor" class="bg-miss-blueSoft py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl">
                        <p class="section-kicker">Tutor</p>
                        <h2 class="mt-3 text-3xl font-black leading-tight text-slate-950 sm:text-4xl">Tutor yang Ramah, Terpercaya, dan Terseleksi</h2>
                        <p class="mt-5 text-base leading-8 text-slate-600">Beberapa tutor aktif Missi. Admin akan membantu mencocokkan tutor dengan kebutuhan, karakter, dan jadwal belajar anak.</p>
                    </div>
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('tutors.public.index') }}" class="focus-ring inline-flex rounded-full border border-miss-navy/15 bg-white px-6 py-3 text-sm font-black text-miss-navy shadow-sm hover:bg-miss-blueSoft">
                            Lihat Tutor Lainnya
                        </a>
                        <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring inline-flex rounded-full bg-miss-navy px-6 py-3 text-sm font-black text-white hover:bg-miss-navyDark">
                            Konsultasi Tutor yang Cocok
                        </a>
                    </div>
                </div>

                @if(($landingTutors ?? collect())->isNotEmpty())
                    <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach($landingTutors as $tutor)
                            @include('partials.public-tutor-card', ['tutor' => $tutor])
                        @endforeach
                    </div>
                @else
                    <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach(['Tutor dipilih sesuai kebutuhan anak', 'Bidang belajar disesuaikan dengan program', 'Admin membantu koordinasi jadwal'] as $process)
                            <div class="rounded-lg bg-white p-5 shadow-sm">
                                <p class="font-bold leading-7 text-slate-800">{{ $process }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <section id="testimoni" class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <p class="section-kicker">Cerita Orang Tua</p>
                    <h2 class="mt-3 text-3xl font-black leading-tight text-slate-950 sm:text-4xl">Testimoni Orang Tua</h2>
                    <p class="mt-4 text-base leading-8 text-slate-600">Testimoni publik akan ditampilkan setelah mendapatkan izin publikasi dari orang tua siswa.</p>
                </div>
                <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach(['Testimoni program Calistung', 'Testimoni les mapel sekolah', 'Testimoni bahasa Inggris atau program lain'] as $testimonial)
                        <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 p-6">
                            <p class="text-sm font-black text-slate-950">{{ $testimonial }}</p>
                            <p class="mt-3 text-sm leading-7 text-slate-500">[Menunggu testimoni asli dan izin publikasi]</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="area" class="bg-miss-cream py-16 sm:py-20">
            <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
                <div>
                    <p class="section-kicker">Area Layanan</p>
                    <h2 class="mt-3 text-3xl font-black leading-tight text-slate-950 sm:text-4xl">Area Layanan Tutor Bimbel Missi</h2>
                    <p class="mt-5 text-base leading-8 text-slate-600">
                        Saat ini layanan masih berfokus di area Wonosobo dan sekitarnya. Ke depannya Bimbel Missi berencana membuka layanan untuk daerah lain secara bertahap.
                    </p>
                    <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring mt-7 inline-flex rounded-full bg-miss-navy px-6 py-3 text-sm font-black text-white hover:bg-miss-navyDark">
                        Cek Ketersediaan Tutor di Lokasi Saya
                    </a>
                </div>
                <div class="rounded-lg border border-slate-100 bg-white p-6 shadow-sm">
                    <div class="grid gap-3 sm:grid-cols-2">
                        @foreach(['Fokus Wonosobo saat ini', 'Wilayah sekitar Wonosobo', 'Soon daerah lain', 'Ekspansi bertahap'] as $area)
                            <div class="rounded-lg bg-miss-blueSoft p-4 text-sm font-black text-miss-navy">{{ $area }}</div>
                        @endforeach
                    </div>
                    <p class="mt-5 text-sm leading-7 text-slate-500">Hubungi admin untuk memastikan apakah alamat rumah Anda sudah dapat dijangkau tutor yang tersedia.</p>
                </div>
            </div>
        </section>

        <section id="faq" class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="section-kicker">FAQ</p>
                    <h2 class="mt-3 text-3xl font-black leading-tight text-slate-950 sm:text-4xl">Pertanyaan yang Sering Ditanyakan</h2>
                </div>
                <div class="mt-10 space-y-3">
                    @foreach($faqItems as $faq)
                        <details class="group rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-left font-black text-slate-950">
                                {{ $faq['q'] }}
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-miss-blueSoft text-miss-navy transition group-open:rotate-45">+</span>
                            </summary>
                            <p class="mt-4 text-sm leading-7 text-slate-600">{{ $faq['a'] }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="kontak" class="bg-miss-navy py-16 text-white sm:py-20">
            <div class="mx-auto max-w-5xl px-4 text-center sm:px-6 lg:px-8">
                <p class="section-kicker text-miss-gold">Konsultasi Gratis</p>
                <h2 class="mt-3 text-3xl font-black leading-tight sm:text-4xl">Yuk, Temukan Program Belajar yang Cocok untuk Anak Anda</h2>
                <p class="mx-auto mt-5 max-w-2xl text-base leading-8 text-miss-cream">Ceritakan kebutuhan anak kepada kami. Tim Bimbel Missi akan membantu mencarikan program dan tutor yang sesuai.</p>
                <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                    <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring inline-flex justify-center rounded-full bg-miss-gold px-7 py-4 text-base font-black text-white hover:bg-miss-goldDark">Konsultasi Gratis via WhatsApp</a>
                    <a href="{{ $formUrl }}" target="_blank" class="focus-ring inline-flex justify-center rounded-full bg-white px-7 py-4 text-base font-black text-miss-navy hover:bg-miss-blueSoft">Isi Formulir Online</a>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-slate-950 py-12 text-slate-300">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 md:grid-cols-4 lg:px-8">
            <div class="md:col-span-2">
                <img src="{{ asset('images/logo1.png') }}" alt="Logo Bimbel Missi" class="h-12 w-auto">
                <p class="mt-4 max-w-md text-sm leading-7 text-slate-400">Bimbel Missi membantu orang tua menemukan pendamping belajar yang lebih personal untuk anak, dengan layanan privat ke rumah dan laporan perkembangan.</p>
            </div>
            <div>
                <p class="font-black text-white">Navigasi</p>
                <div class="mt-4 grid gap-2 text-sm">
                    <a href="#program" class="hover:text-white">Program</a>
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
                    <span>Fokus Wonosobo saat ini, soon daerah lain</span>
                </div>
            </div>
        </div>
        <div class="mx-auto mt-10 flex max-w-7xl flex-col gap-3 border-t border-slate-800 px-4 pt-6 text-sm text-slate-500 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
            <p>&copy; {{ now()->year }} Bimbel Missi. All rights reserved.</p>
            <p>Data testimoni, profil tutor, harga publik, dan video hero dapat ditambahkan saat aset resmi tersedia.</p>
        </div>
    </footer>

    <a href="{{ $whatsappUrl }}" target="_blank" class="focus-ring fixed bottom-4 right-4 z-40 inline-flex items-center justify-center rounded-full bg-miss-gold px-4 py-3 text-sm font-black text-white shadow-2xl shadow-slate-950/20 hover:bg-miss-goldDark sm:px-5 sm:py-4">
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

            if (activeScrollAnimation) {
                cancelAnimationFrame(activeScrollAnimation);
            }

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

        btn?.addEventListener('click', () => {
            menu?.classList.toggle('hidden');
        });

        menu?.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => menu.classList.add('hidden'));
        });

        document.querySelectorAll('a[href^="#"]').forEach((link) => {
            link.addEventListener('click', (event) => {
                const targetId = link.getAttribute('href');

                if (!targetId || targetId === '#') {
                    return;
                }

                const target = document.querySelector(targetId);

                if (!target) {
                    return;
                }

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
            if (element.dataset.counted === 'true') {
                return;
            }

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
                    if (!entry.isIntersecting) {
                        return;
                    }

                    statValues.forEach((element) => animateStatValue(element));
                    observer.disconnect();
                });
            }, { threshold: 0.35 });

            statsObserver.observe(statsSection);
        }
    </script>
</body>
</html>
