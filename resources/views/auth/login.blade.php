<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Bimbel') }} - Login</title>

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

        body {
            background-color: #0b1120; /* Very dark slate, almost navy */
            background-image: flex;
        }

        /* Subtle ambient lighting */
        .ambient-glow-1 {
            position: absolute;
            top: -10%;
            left: -10%;
            width: 50vw;
            height: 50vw;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.15) 0%, transparent 60%);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }

        .ambient-glow-2 {
            position: absolute;
            bottom: -20%;
            right: -10%;
            width: 60vw;
            height: 60vw;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.1) 0%, transparent 60%);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }

        /* Premium glass effect */
        .glass-panel {
            background: rgba(30, 41, 59, 0.4); /* Slate 800 with opacity */
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .input-premium {
            background: rgba(15, 23, 42, 0.6); /* Slate 900 */
            border: 1px solid rgba(71, 85, 105, 0.4);
            color: #f8fafc;
            transition: all 0.3s ease;
        }

        .input-premium:focus {
            background: rgba(15, 23, 42, 0.8);
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
            outline: none;
        }

        .btn-premium {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            box-shadow: 0 4px 14px 0 rgba(79, 70, 229, 0.39);
            transition: all 0.3s ease;
        }

        .btn-premium:hover {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
            transform: translateY(-1px);
        }
        
        .feature-icon-box {
            background: linear-gradient(145deg, rgba(30, 41, 59, 0.8), rgba(15, 23, 42, 0.9));
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Ambient Lighting -->
    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>

    <!-- Login Container -->
    <div class="relative z-10 w-full max-w-6xl mx-auto glass-panel rounded-[2.5rem] overflow-hidden flex flex-col lg:flex-row">
        
        <!-- Left Side - Branding -->
        <div class="hidden lg:flex w-5/12 p-14 flex-col justify-between border-r border-slate-700/50 relative">
            
            <div class="relative z-10">
                <!-- Logo -->
                <div class="mb-10">
                    @if(file_exists(public_path('images/logo1.png')))
                        <div class="bg-white/10 p-4 rounded-2xl inline-block backdrop-blur-md border border-white/10">
                            <img src="{{ asset('images/logo1.png') }}" alt="Logo" class="h-10 w-auto">
                        </div>
                    @else
                        <div class="h-16 w-16 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/30">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <!-- Title & Desc -->
                <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-6 leading-tight tracking-tight">
                    Sistem Bimbel<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">Enterprise</span>
                </h1>
                <p class="text-slate-400 text-lg mb-12 max-w-sm leading-relaxed">
                    Corporate management platform integrasi eksklusif untuk operasional bimbingan belajar modern.
                </p>
                
                <!-- Features List -->
                <div class="space-y-6">
                    <div class="flex items-center gap-5 text-slate-300 group">
                        <div class="h-12 w-12 rounded-2xl flex items-center justify-center feature-icon-box group-hover:border-indigo-500/50 transition-colors">
                            <svg class="h-5 w-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-sm tracking-wide">Secure Access</h3>
                            <p class="text-sm text-slate-500 mt-1">Sistem login terenkripsi ganda.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-5 text-slate-300 group">
                        <div class="h-12 w-12 rounded-2xl flex items-center justify-center feature-icon-box group-hover:border-cyan-500/50 transition-colors">
                            <svg class="h-5 w-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-sm tracking-wide">Real-time Sync</h3>
                            <p class="text-sm text-slate-500 mt-1">Data akademik dimutakhirkan instan.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="relative z-10 mt-16 border-t border-slate-700/50 pt-6">
                <p class="text-xs font-semibold text-slate-500 tracking-wider">
                    © {{ date('Y') }} SISTEM BIMBEL. ALL RIGHTS RESERVED.
                </p>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-7/12 p-8 sm:p-12 lg:p-16 xl:p-20 flex flex-col justify-center bg-slate-900/40 relative">
            
            <!-- Mobile Logo -->
            <div class="lg:hidden text-center mb-10">
                @if(file_exists(public_path('images/logo1.png')))
                    <div class="bg-white/10 p-3 rounded-2xl inline-block backdrop-blur-md mb-4 border border-white/5">
                        <img src="{{ asset('images/logo1.png') }}" alt="Logo" class="h-10 w-auto mx-auto">
                    </div>
                @else
                    <div class="h-14 w-14 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg mx-auto mb-4">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                @endif
                <h2 class="text-2xl font-bold text-white">Sistem Bimbel</h2>
            </div>

            <div class="max-w-md mx-auto w-full relative z-10">
                <!-- Desktop Header -->
                <div class="mb-10 text-center lg:text-left">
                    <h2 class="text-3xl font-bold text-white mb-3">Sign in to workspace</h2>
                    <p class="text-slate-400 font-medium text-sm">Enter your registered organizational email & password.</p>
                </div>

                <!-- Error Messages -->
                @if (session('status'))
                    <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 rounded-xl p-4 flex items-start gap-3">
                        <svg class="h-5 w-5 text-emerald-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-emerald-400 text-sm font-medium">{{ session('status') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 bg-rose-500/10 border border-rose-500/20 rounded-xl p-4 flex items-start gap-3">
                        <svg class="h-5 w-5 text-rose-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <ul class="text-rose-400 text-sm font-medium space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">
                            Organizational Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                                   class="input-premium block w-full pl-11 pr-4 py-3.5 rounded-xl text-sm placeholder:text-slate-600"
                                   placeholder="name@company.com">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-xs font-bold text-slate-400 uppercase tracking-wide">
                                Password
                            </label>
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
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition-colors">
                                    Forgot?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                   class="input-premium block w-full pl-11 pr-4 py-3.5 rounded-xl text-sm placeholder:text-slate-600"
                                   placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center pt-2">
                        <label class="flex items-center cursor-pointer group">
                            <div class="relative flex items-center">
                                <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-600 bg-slate-800 text-indigo-500 focus:ring-indigo-500/50 focus:ring-offset-0 cursor-pointer transition-colors">
                            </div>
                            <span class="ml-3 text-sm font-medium text-slate-400 group-hover:text-slate-300 transition-colors">Keep me signed in</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="btn-premium w-full text-white font-bold py-3.5 px-6 rounded-xl flex items-center justify-center gap-2 mt-4 text-sm">
                        Authenticate
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </form>

                <!-- Demo Credentials -->
                <div class="mt-12 pt-8 border-t border-slate-800">
                    <p class="text-[10px] font-bold text-slate-500 text-center mb-5 uppercase tracking-widest">Sandbox Access Credentials</p>
                    <div class="grid grid-cols-3 gap-3">
                        <div class="bg-slate-800/50 hover:bg-slate-800 border border-slate-700 hover:border-indigo-500/50 rounded-xl p-3 text-center cursor-pointer transition-all group" onclick="document.getElementById('email').value='admin@bimbel.com'; document.getElementById('password').value='password';">
                            <p class="font-bold text-indigo-400 group-hover:text-indigo-300 text-[11px] uppercase tracking-wider mb-1 transition-colors">Admin</p>
                            <p class="text-slate-500 group-hover:text-slate-400 text-[10px] truncate transition-colors" title="admin@bimbel.com">admin@...</p>
                        </div>
                        <div class="bg-slate-800/50 hover:bg-slate-800 border border-slate-700 hover:border-cyan-500/50 rounded-xl p-3 text-center cursor-pointer transition-all group" onclick="document.getElementById('email').value='ahmad.tutor@bimbel.com'; document.getElementById('password').value='password';">
                            <p class="font-bold text-cyan-400 group-hover:text-cyan-300 text-[11px] uppercase tracking-wider mb-1 transition-colors">Tutor</p>
                            <p class="text-slate-500 group-hover:text-slate-400 text-[10px] truncate transition-colors" title="ahmad.tutor@bimbel.com">ahmad@...</p>
                        </div>
                        <div class="bg-slate-800/50 hover:bg-slate-800 border border-slate-700 hover:border-purple-500/50 rounded-xl p-3 text-center cursor-pointer transition-all group" onclick="document.getElementById('email').value='rina.client@bimbel.com'; document.getElementById('password').value='password';">
                            <p class="font-bold text-purple-400 group-hover:text-purple-300 text-[11px] uppercase tracking-wider mb-1 transition-colors">Client</p>
                            <p class="text-slate-500 group-hover:text-slate-400 text-[10px] truncate transition-colors" title="rina.client@bimbel.com">rina@...</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Mobile Footer -->
            <p class="lg:hidden text-center text-slate-600 text-xs mt-12 font-semibold tracking-wider">
                © {{ date('Y') }} SISTEM BIMBEL
            </p>
        </div>
    </div>

</body>
</html>
