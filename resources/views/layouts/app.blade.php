<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Bimbel') }} - @yield('title', 'Dashboard')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus+jakarta+sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            navy: {
                                50: '#f1f5f9', 100: '#e2e8f0', 200: '#cbd5e1', 300: '#94a3b8',
                                400: '#64748b', 500: '#475569', 600: '#205085', 700: '#1b406b',
                                800: '#0f172a', 900: '#0b1120',
                            },
                            gold: {
                                500: '#c28552', 600: '#b46c43',
                            }
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        :root {
            --primary: #205085; /* brand-navy-600 */
            --primary-dark: #1b406b; /* brand-navy-700 */
            --secondary: #c28552; /* brand-gold-500 */
            --accent: #b46c43; /* brand-gold-600 */
        }
        
        .sidebar-gradient {
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-slate-900 font-sans antialiased" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false" 
             class="fixed inset-0 z-40 sidebar-overlay md:hidden"
             style="display: none;"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
               class="w-72 sidebar-gradient shadow-2xl fixed h-full overflow-y-auto border-r border-slate-700/50 z-50 transition-transform duration-300 ease-in-out sidebar-scroll">
            <!-- Logo Section -->
            <div class="p-6 border-b border-slate-700/50">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    @if(file_exists(public_path('images/logo1.png')))
                        <img src="{{ asset('images/logo1.png') }}" alt="Logo" class="h-12 w-auto">
                    @else
                        <div class="h-12 w-12 bg-indigo-600 rounded-xl flex items-center justify-center shadow-md shadow-indigo-500/20 transition-all duration-300">
                            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-white font-bold text-lg">Sistem Bimbel</h1>
                        <p class="text-slate-400 text-xs">Sistem Manajemen</p>
                    </div>
                </a>
            </div>
            
            <!-- User Info -->
            <div class="p-4 border-b border-slate-700/50">
                <div class="flex items-center gap-3 p-3 bg-slate-800/50 rounded-2xl border border-slate-700/50">
                    <img class="h-10 w-10 rounded-xl object-cover ring-2 ring-indigo-500/30" 
                         src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=205085&color=fff&size=128' }}" 
                         alt="{{ auth()->user()->name }}">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400 capitalize">
                            {{ auth()->user()->role === 'admin' ? 'Administrator' : (auth()->user()->role === 'tutor' ? 'Pengajar' : 'Wali Murid') }}
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="p-4 space-y-1">
                @include('layouts.partials.sidebar-menu')
            </nav>
            
            <!-- Logout -->
            <div class="p-4 border-t border-slate-700/50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-red-500/10 hover:text-red-300 rounded-xl transition-all duration-200 border border-transparent hover:border-red-500/30">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="font-semibold">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 md:ml-72 min-w-0">
            <!-- Top Navigation -->
            <header class="bg-slate-900/80 backdrop-blur-xl border-b border-slate-700/50 sticky top-0 z-30">
                <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-5 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <!-- Mobile Hamburger -->
                        <button @click="sidebarOpen = !sidebarOpen" 
                                class="md:hidden p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <div>
                            <h1 class="text-xl sm:text-2xl font-black text-white">@yield('page-title', 'Dashboard')</h1>
                            <p class="text-xs sm:text-sm text-slate-400 mt-0.5">@yield('page-subtitle', 'Selamat datang kembali!')</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <!-- Date Display (Desktop) -->
                        <div class="hidden lg:flex items-center gap-2 px-4 py-2 bg-slate-800/50 rounded-xl border border-slate-700/50">
                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-slate-300 text-sm font-medium">{{ now()->translatedFormat('l, d M Y') }}</span>
                        </div>

                        <!-- Notifications -->
                        <a href="{{ route('notifications.index') }}" class="relative p-2.5 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-all duration-200 border border-transparent hover:border-slate-600">
                            <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @php
                                $unreadCount = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="absolute top-1 right-1 h-5 w-5 bg-gradient-to-br from-red-500 to-pink-500 rounded-full ring-2 ring-slate-900 flex items-center justify-center">
                                    <span class="text-white text-[10px] font-bold">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                                </span>
                            @endif
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 sm:p-6 lg:p-8">
                @if(session('success'))
                    <div class="mb-6 bg-gradient-to-r from-green-500/10 to-emerald-500/10 border border-green-500/30 p-5 rounded-2xl animate-fade-in-up">
                        <div class="flex items-start gap-3">
                            <div class="h-8 w-8 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center flex-shrink-0">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-green-400 font-bold">Berhasil!</p>
                                <p class="text-green-300 text-sm mt-0.5">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6 bg-gradient-to-r from-red-500/10 to-pink-500/10 border border-red-500/30 p-5 rounded-2xl animate-fade-in-up">
                        <div class="flex items-start gap-3">
                            <div class="h-8 w-8 rounded-xl bg-gradient-to-br from-red-500 to-pink-600 flex items-center justify-center flex-shrink-0">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-red-400 font-bold">Kesalahan</p>
                                <p class="text-red-300 text-sm mt-0.5">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
