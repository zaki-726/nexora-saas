@php
    $currentRoute = Route::currentRouteName();
    $isBillingActive = in_array($currentRoute, [
        'admin.plans.index',
        'admin.subscriptions.index',
        'admin.payments.index',
        'admin.payments.show',
        'admin.invoices.index'
    ]);
@endphp

<aside x-cloak
       class="fixed inset-y-0 left-0 z-50 flex flex-col bg-white/85 backdrop-blur-2xl border-r border-slate-200/90 transition-all duration-300 shadow-[4px_0_30px_rgba(15,23,42,0.03)]"
       :class="{
           'translate-x-0': sidebarOpen,
           '-translate-x-full lg:translate-x-0': !sidebarOpen,
           'w-64': !sidebarCollapsed,
           'w-20': sidebarCollapsed
       }">
    
    <!-- Sidebar Header / Glass Brand -->
    <div class="h-16 flex items-center px-4 border-b border-slate-200/80 bg-white/60 backdrop-blur-md justify-between">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 overflow-hidden group">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-cyan-400 p-[1.5px] shadow-md shadow-indigo-500/20 shrink-0 group-hover:scale-105 transition-transform">
                <div class="w-full h-full bg-white rounded-[14px] flex items-center justify-center text-indigo-600 font-black text-xl">
                    N
                </div>
            </div>
            <div class="flex flex-col transition-opacity duration-200" x-show="!sidebarCollapsed">
                <span class="font-extrabold text-base tracking-tight text-slate-900 flex items-center gap-1.5">
                    NEXORA <span class="text-[9px] uppercase font-bold px-1.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200/80">SaaS</span>
                </span>
                <span class="text-[10px] text-slate-500 font-medium">Super Admin Console</span>
            </div>
        </a>

        <!-- Mobile Close Button -->
        <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-slate-700 p-1 rounded-xl hover:bg-slate-100 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Navigation Menu Items -->
    <div class="flex-1 overflow-y-auto px-3 py-4 space-y-1.5 scrollbar-thin">
        
        <!-- Section: Overview -->
        <div class="px-3 pt-1 pb-1 text-[10px] font-bold uppercase tracking-wider text-slate-400" x-show="!sidebarCollapsed">
            Platform Engine
        </div>

        <!-- 1. Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="group flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-semibold transition-all relative {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50/90 text-indigo-700 border border-indigo-200 shadow-sm' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900 border border-transparent' }}"
           :title="sidebarCollapsed ? 'Dashboard' : ''">
            <div class="shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-indigo-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <span class="truncate transition-opacity" x-show="!sidebarCollapsed">Dashboard</span>
            @if(request()->routeIs('admin.dashboard'))
                <span class="absolute right-2.5 w-1.5 h-4 bg-indigo-600 rounded-full shadow-sm" x-show="!sidebarCollapsed"></span>
            @endif
        </a>

        <!-- Section: Core Management -->
        <div class="px-3 pt-4 pb-1 text-[10px] font-bold uppercase tracking-wider text-slate-400" x-show="!sidebarCollapsed">
            Multi-Tenant Management
        </div>

        <!-- 2. Companies -->
        <a href="{{ route('admin.companies.index') }}" 
           class="group flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-semibold transition-all relative {{ request()->routeIs('admin.companies.*') ? 'bg-indigo-50/90 text-indigo-700 border border-indigo-200 shadow-sm' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900 border border-transparent' }}"
           :title="sidebarCollapsed ? 'Companies' : ''">
            <div class="shrink-0 {{ request()->routeIs('admin.companies.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-indigo-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <span class="truncate transition-opacity" x-show="!sidebarCollapsed">Companies</span>
            <span class="ml-auto text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200" x-show="!sidebarCollapsed">
                {{ \App\Models\Company::count() }}
            </span>
        </a>

        <!-- 3. Users -->
        <a href="{{ route('admin.users.index') }}" 
           class="group flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-semibold transition-all relative {{ request()->routeIs('admin.users.*') ? 'bg-indigo-50/90 text-indigo-700 border border-indigo-200 shadow-sm' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900 border border-transparent' }}"
           :title="sidebarCollapsed ? 'Users' : ''">
            <div class="shrink-0 {{ request()->routeIs('admin.users.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-indigo-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <span class="truncate transition-opacity" x-show="!sidebarCollapsed">Users</span>
            <span class="ml-auto text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200" x-show="!sidebarCollapsed">
                {{ \App\Models\User::count() }}
            </span>
        </a>

        <!-- Section: Billing & Plans (Expandable Light Glass Dropdown) -->
        <div class="px-3 pt-4 pb-1 text-[10px] font-bold uppercase tracking-wider text-slate-400" x-show="!sidebarCollapsed">
            Subscriptions & Finance
        </div>

        <div x-data="{ open: {{ $isBillingActive ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open" 
                    type="button" 
                    class="w-full group flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-semibold transition-all {{ $isBillingActive ? 'text-indigo-700 bg-indigo-50/80 border border-indigo-200' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900 border border-transparent' }}"
                    :title="sidebarCollapsed ? 'Billing & Subscriptions' : ''">
                <div class="shrink-0 {{ $isBillingActive ? 'text-indigo-600' : 'text-slate-400 group-hover:text-indigo-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <span class="truncate flex-1 text-left" x-show="!sidebarCollapsed">Billing & Plans</span>
                <svg class="w-3.5 h-3.5 transition-transform duration-200" 
                     :class="open ? 'rotate-180 text-indigo-600' : 'text-slate-400'" 
                     x-show="!sidebarCollapsed"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <!-- Dropdown Sub-links -->
            <div x-show="open || sidebarCollapsed" 
                 x-collapse
                 class="space-y-1 pl-3">

                <!-- 4. Plans -->
                <a href="{{ route('admin.plans.index') }}" 
                   class="group flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('admin.plans.*') ? 'text-indigo-700 bg-indigo-50 font-bold' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-100/50' }}"
                   :title="sidebarCollapsed ? 'Subscription Plans' : ''">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.plans.*') ? 'bg-indigo-600 ring-2 ring-indigo-200' : 'bg-slate-400 group-hover:bg-indigo-600' }}"></span>
                    <span class="truncate" x-show="!sidebarCollapsed">Subscription Plans</span>
                </a>

                <!-- 5. Subscriptions -->
                <a href="{{ route('admin.subscriptions.index') }}" 
                   class="group flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('admin.subscriptions.*') ? 'text-indigo-700 bg-indigo-50 font-bold' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-100/50' }}"
                   :title="sidebarCollapsed ? 'Subscriptions' : ''">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.subscriptions.*') ? 'bg-indigo-600 ring-2 ring-indigo-200' : 'bg-slate-400 group-hover:bg-indigo-600' }}"></span>
                    <span class="truncate" x-show="!sidebarCollapsed">Subscriptions</span>
                </a>

                <!-- 6. Payments -->
                <a href="{{ route('admin.payments.index') }}" 
                   class="group flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('admin.payments.*') ? 'text-indigo-700 bg-indigo-50 font-bold' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-100/50' }}"
                   :title="sidebarCollapsed ? 'Payments' : ''">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.payments.*') ? 'bg-indigo-600 ring-2 ring-indigo-200' : 'bg-slate-400 group-hover:bg-indigo-600' }}"></span>
                    <span class="truncate" x-show="!sidebarCollapsed">Payments</span>
                </a>

                <!-- 7. Invoices -->
                <a href="{{ route('admin.invoices.index') }}" 
                   class="group flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('admin.invoices.*') ? 'text-indigo-700 bg-indigo-50 font-bold' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-100/50' }}"
                   :title="sidebarCollapsed ? 'Invoices' : ''">
                    <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.invoices.*') ? 'bg-indigo-600 ring-2 ring-indigo-200' : 'bg-slate-400 group-hover:bg-indigo-600' }}"></span>
                    <span class="truncate" x-show="!sidebarCollapsed">Invoices</span>
                </a>
            </div>
        </div>

        <!-- Section: Operations -->
        <div class="px-3 pt-4 pb-1 text-[10px] font-bold uppercase tracking-wider text-slate-400" x-show="!sidebarCollapsed">
            Platform Operations
        </div>

        <!-- 8. Support Tickets -->
        <a href="{{ route('admin.tickets.index') }}" 
           class="group flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-semibold transition-all relative {{ request()->routeIs('admin.tickets.*') ? 'bg-indigo-50/90 text-indigo-700 border border-indigo-200 shadow-sm' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900 border border-transparent' }}"
           :title="sidebarCollapsed ? 'Support Tickets' : ''">
            <div class="shrink-0 {{ request()->routeIs('admin.tickets.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-indigo-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <span class="truncate transition-opacity" x-show="!sidebarCollapsed">Support Tickets</span>
            @php $pendingCount = \App\Models\SupportTicket::whereIn('status', ['open', 'in_progress'])->count(); @endphp
            @if($pendingCount > 0)
                <span class="ml-auto text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200" x-show="!sidebarCollapsed">
                    {{ $pendingCount }}
                </span>
            @endif
        </a>

        <!-- 9. Announcements -->
        <a href="{{ route('admin.announcements.index') }}" 
           class="group flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-semibold transition-all relative {{ request()->routeIs('admin.announcements.*') ? 'bg-indigo-50/90 text-indigo-700 border border-indigo-200 shadow-sm' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900 border border-transparent' }}"
           :title="sidebarCollapsed ? 'Announcements' : ''">
            <div class="shrink-0 {{ request()->routeIs('admin.announcements.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-indigo-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
            </div>
            <span class="truncate transition-opacity" x-show="!sidebarCollapsed">Announcements</span>
        </a>

        <!-- 10. Activity Logs -->
        <a href="{{ route('admin.activities.index') }}" 
           class="group flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-semibold transition-all relative {{ request()->routeIs('admin.activities.*') ? 'bg-indigo-50/90 text-indigo-700 border border-indigo-200 shadow-sm' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900 border border-transparent' }}"
           :title="sidebarCollapsed ? 'Activity Logs' : ''">
            <div class="shrink-0 {{ request()->routeIs('admin.activities.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-indigo-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <span class="truncate transition-opacity" x-show="!sidebarCollapsed">Activity Logs</span>
        </a>

        <!-- 11. Settings -->
        <a href="{{ route('admin.settings.index') }}" 
           class="group flex items-center gap-3 px-3.5 py-2.5 rounded-2xl text-xs font-semibold transition-all relative {{ request()->routeIs('admin.settings.*') ? 'bg-indigo-50/90 text-indigo-700 border border-indigo-200 shadow-sm' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900 border border-transparent' }}"
           :title="sidebarCollapsed ? 'Settings' : ''">
            <div class="shrink-0 {{ request()->routeIs('admin.settings.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-indigo-600' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <span class="truncate transition-opacity" x-show="!sidebarCollapsed">Settings</span>
        </a>
    </div>

    <!-- 12. Bottom User Profile Glass Panel & Logout -->
    <div class="p-3 border-t border-slate-200/80 bg-slate-50/60 backdrop-blur-md">
        <div class="flex items-center gap-3 p-2.5 rounded-2xl glass-card">
            <!-- Glass Avatar -->
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white font-bold text-xs shadow-sm shrink-0 border border-white">
                {{ substr(Auth::user()?->name ?? 'SA', 0, 2) }}
            </div>

            <!-- Profile Info (Hidden when collapsed) -->
            <div class="flex-1 min-w-0" x-show="!sidebarCollapsed">
                <p class="text-xs font-bold text-slate-800 truncate">
                    {{ Auth::user()?->name ?? 'Super Admin' }}
                </p>
                <p class="text-[10px] text-slate-500 truncate font-mono">
                    {{ Auth::user()?->email ?? 'admin@nexora.test' }}
                </p>
            </div>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('admin.logout') }}" x-show="!sidebarCollapsed" class="shrink-0">
                @csrf
                <button type="submit" 
                        title="Logout from Admin"
                        class="p-1.5 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Separate icon logout for collapsed view -->
        <div x-show="sidebarCollapsed" class="mt-2 flex justify-center">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" 
                        title="Logout" 
                        class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>
