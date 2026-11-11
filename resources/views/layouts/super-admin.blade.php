<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F6F8FC] text-slate-800">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Super Admin Console') - Nexora SaaS</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Luminous Pearlescent Glass Styling for Light Theme -->
    <style>
        [x-cloak] { display: none !important; }
        
        /* Gracious Light Glass Panel */
        .glass-panel {
            background: rgba(255, 255, 255, 0.78);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 10px 30px -4px rgba(15, 23, 42, 0.05), 
                        0 4px 12px -2px rgba(15, 23, 42, 0.03),
                        inset 0 1px 1px 0 rgba(255, 255, 255, 0.9);
        }

        .glass-panel-hover {
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .glass-panel-hover:hover {
            background: rgba(255, 255, 255, 0.92);
            border-color: rgba(99, 102, 241, 0.35);
            box-shadow: 0 16px 36px -4px rgba(99, 102, 241, 0.10), 
                        0 4px 16px -2px rgba(15, 23, 42, 0.04),
                        inset 0 1px 2px 0 rgba(255, 255, 255, 1);
            transform: translateY(-2px);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.70);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 15px 0 rgba(15, 23, 42, 0.03), 
                        inset 0 1px 1px 0 rgba(255, 255, 255, 0.8);
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(203, 213, 225, 0.8);
            color: #0f172a;
        }
        .glass-input:focus {
            background: #ffffff;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        /* Pearlescent Glass Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(241, 245, 249, 0.6);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.4);
            border-radius: 9999px;
            backdrop-filter: blur(4px);
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(99, 102, 241, 0.6);
        }
    </style>
    @stack('styles')
</head>
<body class="h-full bg-[#F6F8FC] text-slate-800 font-sans antialiased selection:bg-indigo-500/20 selection:text-indigo-800 overflow-x-hidden"
      x-data="{ 
          sidebarOpen: false, 
          sidebarCollapsed: localStorage.getItem('nexora_sidebar_collapsed') === 'true',
          toggleSidebar() {
              this.sidebarCollapsed = !this.sidebarCollapsed;
              localStorage.setItem('nexora_sidebar_collapsed', this.sidebarCollapsed);
          }
      }">

    <!-- Ambient Luminous Background Orbs for Gracious Light Theme -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <!-- Soft Rose Glow Top Right -->
        <div class="absolute -top-[12%] -right-[10%] w-[50vw] h-[50vw] rounded-full bg-gradient-to-br from-rose-200/40 via-pink-100/30 to-transparent blur-[110px]"></div>
        <!-- Soft Lavender & Indigo Glow Top Left -->
        <div class="absolute -top-[15%] -left-[10%] w-[55vw] h-[55vw] rounded-full bg-gradient-to-tr from-indigo-200/45 via-purple-100/35 to-transparent blur-[120px]"></div>
        <!-- Soft Cyan & Sky Blue Center Bottom -->
        <div class="absolute top-[40%] left-[20%] w-[50vw] h-[50vw] rounded-full bg-gradient-to-t from-sky-200/35 via-cyan-100/25 to-transparent blur-[130px]"></div>
        <!-- Delicate geometric background grid -->
        <div class="absolute inset-0 bg-[radial-gradient(rgba(148,163,184,0.12)_1px,transparent_1px)] [background-size:24px_24px] opacity-70"></div>
    </div>

    <div class="min-h-full flex flex-col lg:flex-row relative z-10">
        
        <!-- Mobile Sidebar Overlay Backdrop -->
        <div x-cloak
             x-show="sidebarOpen" 
             @click="sidebarOpen = false"
             class="fixed inset-0 z-40 bg-slate-900/30 backdrop-blur-sm lg:hidden transition-opacity"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        <!-- Glass Sidebar Include -->
        @include('admin.partials.sidebar')

        <!-- Main Content Area Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 transition-all duration-300"
             :class="sidebarCollapsed ? 'lg:pl-20' : 'lg:pl-64'">
            
            <!-- Glass Topbar Include -->
            @include('admin.partials.navbar')

            <!-- Global Alerts Include -->
            @include('admin.partials.alerts')

            <!-- Main Page Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 space-y-6">
                @yield('content')
            </main>

            <!-- Gracious Light Glass Footer -->
            <footer class="glass-panel border-t border-slate-200/80 px-6 py-4 text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-3 mt-auto">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="font-bold text-slate-700">Nexora SaaS Platform Engine v2.4</span>
                    <span class="text-slate-300">|</span>
                    <span class="text-slate-500">Gracious Light Glass Edition &bull; <strong class="text-indigo-600 font-semibold">Active</strong></span>
                </div>
                <div class="flex items-center gap-4 text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition font-medium">Dashboard</a>
                    <a href="{{ route('admin.tickets.index') }}" class="hover:text-indigo-600 transition font-medium">Support Queue</a>
                    <span>&copy; {{ date('Y') }} Nexora Inc. All rights reserved.</span>
                </div>
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
