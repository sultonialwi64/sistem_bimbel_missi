<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bimbel Miss I - Official Website</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Glassmorphism Utility */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 overflow-x-hidden">

    <nav class="fixed w-full z-50 glass transition-all duration-300" id="navbar">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer">
                    <img src="{{ asset('images/Foto4.jpeg') }}" alt="Logo Miss I" class="w-10 h-10 rounded-lg object-cover">
                    <span class="font-bold text-xl tracking-tight text-brand-900">Missi Private Course</span>
                </div>
                
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#home" class="text-gray-600 hover:text-brand-600 font-medium transition">Beranda</a>
                    <a href="#program" class="text-gray-600 hover:text-brand-600 font-medium transition">Program</a>
                    <a href="#galeri" class="text-gray-600 hover:text-brand-600 font-medium transition">Galeri</a>
                    <a href="#tentang" class="text-gray-600 hover:text-brand-600 font-medium transition">Tentang</a>
                    
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-brand-600 font-medium transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-brand-600 font-medium transition">Login Portal</a>
                        @endauth
                    @endif

                    <a href="#kontak" class="bg-brand-600 text-white px-5 py-2.5 rounded-full font-medium hover:bg-brand-700 transition shadow-lg shadow-brand-500/30 transform hover:-translate-y-0.5">
                        Daftar Sekarang
                    </a>
                </div>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-gray-600 hover:text-brand-600 focus:outline-none">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 absolute w-full">
            <div class="px-4 pt-2 pb-6 space-y-2 shadow-lg">
                <a href="#home" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-brand-50 hover:text-brand-600">Beranda</a>
                <a href="#program" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-brand-50 hover:text-brand-600">Program</a>
                <a href="#galeri" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-brand-50 hover:text-brand-600">Galeri</a>
                <a href="#tentang" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-brand-50 hover:text-brand-600">Tentang</a>
                
                @auth
                    <a href="{{ url('/dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-brand-50 hover:text-brand-600">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-brand-50 hover:text-brand-600">Login Portal</a>
                @endauth

                <a href="#kontak" class="block px-3 py-2 mt-4 text-center rounded-md text-base font-medium bg-brand-600 text-white">Daftar Sekarang</a>
            </div>
        </div>
    </nav>

    <section id="home" class="pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden relative">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-brand-100 rounded-full blur-3xl opacity-50 z-0"></div>
        
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-right" data-aos-duration="1000">
                    <span class="inline-block py-1 px-3 rounded-full bg-brand-100 text-brand-600 text-sm font-semibold mb-4">
                        🚀 Pendaftaran Tahun Ajaran 2026/2027 Dibuka
                    </span>
                    <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
                        Belajar Jadi Lebih <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-purple-600">Mudah & Seru :</span>
                       
                        <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-6">
                            Metode Personal untuk Hasil Optimal 
                        </h2>
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        “Program les kami menerapkan metode pembelajaran yang disesuaikan dengan kebutuhan, kemampuan, dan tujuan setiap siswa sehingga proses belajar menjadi lebih efektif dan tepat sasaran. Didukung oleh beragam pilihan program dan pengembangan berbagai keterampilan, kami berkomitmen membantu siswa mencapai hasil belajar yang optimal secara terarah dan berkelanjutan”
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#kontak" class="px-8 py-4 bg-brand-600 text-white rounded-xl font-semibold shadow-lg shadow-brand-500/40 hover:bg-brand-700 transition transform hover:-translate-y-1 text-center">
                            Daftar Gratis
                        </a>
                        <a href="#program" class="px-8 py-4 bg-white text-gray-700 border border-gray-200 rounded-xl font-semibold hover:bg-gray-50 transition text-center flex items-center justify-center gap-2">
                            Lihat Program
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </a>
                    </div>
                </div>
                
                <div class="relative" data-aos="fade-left" data-aos-duration="1000">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl transform rotate-2 hover:rotate-0 transition duration-500 border-4 border-white">
                        <img src="{{ asset('images/Profil1.jpeg') }}" alt="Suasana Belajar" class="w-full h-auto object-cover">
                        
                        <div class="absolute bottom-6 left-6 bg-white p-4 rounded-xl shadow-xl flex items-center gap-3 animate-bounce">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Metode pembelajaran</p>
                                <p class="font-bold text-gray-800">Beragam</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="program" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl font-bold text-gray-900">Pilihan Program</h2>
                <p class="mt-4 text-gray-500 max-w-2xl mx-auto">Kami menyediakan berbagai program edukasi dan pengembangan diri untuk segala usia.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <div class="group p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-brand-500/10 transition duration-300 transform hover:-translate-y-1" data-aos="fade-up">
                    <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center text-pink-600 mb-4 text-2xl">✏️</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Privat Calistung</h3>
                    <p class="text-gray-500 text-sm">Membaca, Menulis, dan Berhitung untuk anak usia dini.</p>
                </div>

                <div class="group p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-brand-500/10 transition duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="50">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 mb-4 text-2xl">🇬🇧</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Privat Bahasa Inggris</h3>
                    <p class="text-gray-500 text-sm">English Class intensif satu guru satu siswa.</p>
                </div>

                <div class="group p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-brand-500/10 transition duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 mb-4 text-2xl">🗣️</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Bahasa Inggris Berkelompok</h3>
                    <p class="text-gray-500 text-sm">Belajar bahasa Inggris seru bersama teman sebaya.</p>
                </div>

                <div class="group p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-brand-500/10 transition duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="150">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600 mb-4 text-2xl">📚</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Privat Mapel SD–SMA</h3>
                    <p class="text-gray-500 text-sm">Pendampingan belajar untuk semua mata pelajaran sekolah.</p>
                </div>

                <div class="group p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-brand-500/10 transition duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 mb-4 text-2xl">🎨</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Kreatif Mewarnai & Menggambar</h3>
                    <p class="text-gray-500 text-sm">Mengasah kreativitas dan motorik halus anak.</p>
                </div>

                <div class="group p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-brand-500/10 transition duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="250">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-green-600 mb-4 text-2xl">🕌</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Program Mengaji</h3>
                    <p class="text-gray-500 text-sm">Bimbingan baca tulis Al-Qur'an dengan metode tepat.</p>
                </div>

                <div class="group p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-brand-500/10 transition duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center text-yellow-600 mb-4 text-2xl">📝</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Paket Persiapan Tes</h3>
                    <p class="text-gray-500 text-sm">Drilling soal untuk ujian sekolah maupun ujian masuk.</p>
                </div>

                <div class="group p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-brand-500/10 transition duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="350">
                    <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center text-cyan-600 mb-4 text-2xl">🏊</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Privat Renang</h3>
                    <p class="text-gray-500 text-sm">Pelatihan renang dasar hingga mahir dengan instruktur.</p>
                </div>

                <div class="group p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-brand-500/10 transition duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-red-600 mb-4 text-2xl">💻</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Online TOEFL & Speaking</h3>
                    <p class="text-gray-500 text-sm">Paket pembelajaran daring fleksibel untuk sertifikasi bahasa.</p>
                </div>

                <div class="group p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-brand-500/10 transition duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="450">
                    <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center text-rose-600 mb-4 text-2xl">🧩</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Privat Terapi ABK</h3>
                    <p class="text-gray-500 text-sm">Dengan Terapis Profesional untuk anak kebutuhan pendampingan khusus.</p>
                </div>

                <div class="group p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:bg-white hover:shadow-xl hover:shadow-brand-500/10 transition duration-300 transform hover:-translate-y-1 md:col-span-2 lg:col-span-2" data-aos="fade-up" data-aos-delay="500">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 text-2xl flex-shrink-0">🌏</div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">English Community & Event Experience</h3>
                            <p class="text-gray-500 text-sm">Pembelajaran Bahasa Inggris melalui kegiatan komunitas yang seru dan event interaktif.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="galeri" class="py-20 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl font-bold text-gray-900">Galeri Kegiatan</h2>
                <p class="mt-4 text-gray-500 max-w-2xl mx-auto">Dokumentasi keseruan belajar dan keceriaan siswa-siswi Bimbel Miss I.</p>
            </div>

            <div class="flex flex-wrap justify-center gap-6">
                
                <div class="relative group overflow-hidden rounded-2xl shadow-lg w-full md:w-[48%] lg:w-[30%] h-64 cursor-pointer" data-aos="zoom-in">
                    <img src="{{ asset('images/Foto4.jpeg') }}" alt="Kegiatan Belajar" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                </div>

                <div class="relative group overflow-hidden rounded-2xl shadow-lg w-full md:w-[48%] lg:w-[30%] h-64 cursor-pointer" data-aos="zoom-in" data-aos-delay="100">
                    <img src="{{ asset('images/Profile2.jpeg') }}" alt="Mengerjakan Modul" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition duration-300 flex items-end">
                        <p class="text-white p-4 translate-y-full group-hover:translate-y-0 transition duration-300 font-semibold text-sm">
                            Fokus Mengerjakan Latihan
                        </p>
                    </div>
                </div>

                <div class="relative group overflow-hidden rounded-2xl shadow-lg w-full md:w-[48%] lg:w-[30%] h-64 cursor-pointer" data-aos="zoom-in" data-aos-delay="200">
                    <img src="{{ asset('images/Profile3.jpeg') }}" alt="Belajar Digital" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition duration-300 flex items-end">
                        <p class="text-white p-4 translate-y-full group-hover:translate-y-0 transition duration-300 font-semibold text-sm">
                            Metode Pembelajaran Interaktif
                        </p>
                    </div>
                </div>

                <div class="relative group overflow-hidden rounded-2xl shadow-lg w-full md:w-[48%] lg:w-[30%] h-64 cursor-pointer" data-aos="zoom-in" data-aos-delay="300">
                    <img src="{{ asset('images/Profile4.jpeg') }}" alt="Kelas Kreatif" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition duration-300 flex items-end">
                        <p class="text-white p-4 translate-y-full group-hover:translate-y-0 transition duration-300 font-semibold text-sm">
                            Kelas Kreativitas & Seni
                        </p>
                    </div>
                </div>

                <div class="relative group overflow-hidden rounded-2xl shadow-lg w-full md:w-[48%] lg:w-[30%] h-64 cursor-pointer bg-white flex items-center justify-center p-4" data-aos="zoom-in" data-aos-delay="400">
                    <img src="{{ asset('images/Profil1.jpeg') }}" alt="Logo Miss I" class="w-full h-full object-contain transform group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition duration-300 flex items-end">
                        <p class="text-brand-900 p-4 translate-y-full group-hover:translate-y-0 transition duration-300 font-semibold text-sm bg-white/80 w-full">
                            Suasana Belajar Ceria
                        </p>
                    </div>
                </div>

            </div>
            
            <div class="mt-10 text-center">
                <a href="https://www.instagram.com/missiprivatecourse?igsh=bXRqOGpleWxrYWJ5" target="_blank" class="inline-flex items-center gap-2 text-brand-600 font-semibold hover:text-brand-800 transition">
                    Lihat Dokumentasi Lainnya di Instagram
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <section id="kontak" class="py-20 bg-brand-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        
        <div class="max-w-4xl mx-auto px-4 relative z-10 text-center" data-aos="zoom-in">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Siap Meningkatkan Prestasi?</h2>
            <p class="text-brand-100 mb-10 text-lg">Konsultasikan kebutuhan belajarmu sekarang. Admin kami siap membantu 24/7.</p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="https://wa.me/62895392551182" target="_blank" class="flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-xl font-bold text-lg transition shadow-lg transform hover:scale-105">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    Chat via WhatsApp
                </a>
                <a href="https://docs.google.com/forms/d/e/1FAIpQLSe56xKm0Gpq36OrtELzSy2VMTcZMYqee2os50e4JcZWestU6g/viewform?usp=publish-editor" class="flex items-center justify-center gap-2 bg-white text-brand-900 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition">
                    Isi Formulir Online
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-gray-400 py-12 border-t border-gray-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-center md:text-left">
                <span class="text-white font-bold text-xl block mb-2">Miss I</span>
                <p class="text-sm">Membangun generasi cerdas dan berkarakter.</p>
            </div>
            <div class="flex gap-6">
                <a href="#" class="hover:text-white transition">Instagram</a>
                <a href="#" class="hover:text-white transition">Facebook</a>
                <a href="#" class="hover:text-white transition">TikTok</a>
            </div>
            <div class="text-sm">
                &copy; 2026 Bimbel Miss I. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // 1. Inisialisasi Animasi AOS
        AOS.init({
            once: true, // Animasi cuma jalan sekali saat scroll ke bawah
            offset: 100, // Mulai animasi sebelum elemen benar2 muncul
        });

        // 2. Logic Mobile Menu Toggle
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // 3. Close mobile menu when clicking a link
        menu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.add('hidden');
            });
        });
    </script>
</body>
</html>
