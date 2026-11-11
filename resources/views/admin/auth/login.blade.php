<!DOCTYPE html>
<html lang="en" class="h-full bg-[#F6F8FC]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Super Admin Login - Nexora SaaS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    }
                }
            }
        }
    </script>
    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.95);
            box-shadow: 0 20px 40px -8px rgba(15, 23, 42, 0.08), 
                        0 4px 12px -2px rgba(15, 23, 42, 0.04),
                        inset 0 1px 1px 0 rgba(255, 255, 255, 1);
        }
        .glass-input {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(203, 213, 225, 0.8);
            color: #0f172a;
        }
        .glass-input:focus {
            background: #ffffff;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }
    </style>
</head>
<body class="h-full flex items-center justify-center p-4 bg-[#F6F8FC] text-slate-800 font-sans relative overflow-hidden">
    
    <!-- Ambient Luminous Background Orbs for Gracious Light Theme -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-[12%] -right-[10%] w-[50vw] h-[50vw] rounded-full bg-gradient-to-br from-rose-200/40 via-pink-100/30 to-transparent blur-[110px]"></div>
        <div class="absolute -top-[15%] -left-[10%] w-[55vw] h-[55vw] rounded-full bg-gradient-to-tr from-indigo-200/45 via-purple-100/35 to-transparent blur-[120px]"></div>
        <div class="absolute top-[40%] left-[20%] w-[50vw] h-[50vw] rounded-full bg-gradient-to-t from-sky-200/35 via-cyan-100/25 to-transparent blur-[130px]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(rgba(148,163,184,0.12)_1px,transparent_1px)] [background-size:24px_24px] opacity-70"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <!-- Logo & Branding -->
        <div class="text-center mb-7">
            <div class="inline-flex w-14 h-14 rounded-3xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-cyan-500 p-[1px] shadow-xl shadow-indigo-600/20 mb-4">
                <div class="w-full h-full bg-white/90 backdrop-blur-sm rounded-[23px] flex items-center justify-center text-indigo-600 font-black text-2xl">
                    N
                </div>
            </div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900 flex items-center justify-center gap-2">
                <span>Nexora SaaS</span>
                <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">Gracious</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">Super Admin Authentication Portal</p>
        </div>

        <!-- Glass Login Card -->
        <div class="glass-panel rounded-3xl p-6 sm:p-8">
            @if(session('warning'))
                <div class="mb-4 p-3 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-medium">
                    {{ session('warning') }}
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 p-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5 font-mono">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', 'admin@nexora.test') }}" required 
                           class="w-full glass-input rounded-2xl px-4 py-2.5 text-xs text-slate-900 placeholder-slate-400 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5 font-mono">Password</label>
                    <input type="password" name="password" value="password" required 
                           class="w-full glass-input rounded-2xl px-4 py-2.5 text-xs text-slate-900 placeholder-slate-400 focus:outline-none transition">
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600 font-medium">
                        <input type="checkbox" name="remember" checked class="rounded border-slate-300 text-indigo-600 focus:ring-0">
                        <span>Remember session</span>
                    </label>
                    <span class="text-indigo-600 font-bold">Protected Zone</span>
                </div>

                <button type="submit" class="w-full mt-2 py-3 px-4 rounded-2xl font-bold text-xs bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-500 hover:to-indigo-400 text-white shadow-lg shadow-indigo-600/30 border border-white/20 transition duration-150">
                    Sign In to Super Admin
                </button>
            </form>

            <!-- 1-Click Dev Quick Login -->
            <div class="mt-6 pt-5 border-t border-slate-200/70 text-center">
                <p class="text-xs text-slate-500 mb-2.5">Development Environment Quick Test</p>
                <a href="{{ route('admin.quick-login') }}" class="inline-flex items-center justify-center gap-2 w-full py-2.5 px-3 rounded-2xl text-xs font-bold bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 transition">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span>1-Click Super Admin Login (Demo)</span>
                </a>
            </div>
        </div>

        <div class="text-center mt-6 text-xs text-slate-500 font-mono">
            &copy; {{ date('Y') }} Nexora SaaS Management System.
        </div>
    </div>
</body>
</html>