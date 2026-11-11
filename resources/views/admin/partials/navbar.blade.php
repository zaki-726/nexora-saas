<header class="h-16 sticky top-0 z-30 flex items-center justify-between px-4 sm:px-6 glass-panel border-b border-slate-200/80 shadow-sm"
        x-data="{
            isFullscreen: false,
            searchQuery: '',
            searchResults: null,
            searchLoading: false,
            searchOpen: false,
            init() {
                document.addEventListener('fullscreenchange', () => {
                    this.isFullscreen = !!document.fullscreenElement;
                });
                window.addEventListener('keydown', (e) => {
                    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                        e.preventDefault();
                        this.$refs.searchInput?.focus();
                        this.searchOpen = true;
                    }
                    if (e.key === 'Escape') {
                        this.searchOpen = false;
                    }
                });
            },
            toggleFullscreen() {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen().catch(() => {});
                } else {
                    document.exitFullscreen().catch(() => {});
                }
            },
            debounceSearch() {
                if (this.searchQuery.trim().length === 0) {
                    this.searchResults = null;
                    return;
                }
                this.searchLoading = true;
                this.searchOpen = true;
                fetch('{{ route('admin.search') }}?q=' + encodeURIComponent(this.searchQuery), {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(data => {
                    this.searchResults = data;
                    this.searchLoading = false;
                })
                .catch(() => {
                    this.searchLoading = false;
                });
            }
        }">

    <!-- Left: Toggles & Search Bar -->
    <div class="flex items-center gap-3">
        <!-- 1. Mobile Toggle -->
        <button @click="sidebarOpen = true" 
                class="lg:hidden p-2 rounded-2xl glass-card text-slate-600 hover:text-slate-900 transition"
                title="Open mobile sidebar">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- 2. Desktop Collapse Toggle -->
        <button @click="toggleSidebar()" 
                class="hidden lg:flex p-2 rounded-2xl glass-card text-slate-600 hover:text-slate-900 transition"
                title="Toggle sidebar size">
            <svg class="w-4 h-4 transition-transform duration-300" 
                 :class="sidebarCollapsed ? 'rotate-180' : ''"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
        </button>

        <!-- 3. Glass Search Input Bar -->
        <div class="relative w-64 sm:w-80 md:w-96" @click.outside="searchOpen = false">
            <form method="GET" action="{{ route('admin.search') }}">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" 
                           x-ref="searchInput"
                           name="q"
                           x-model="searchQuery"
                           @input.debounce.300ms="debounceSearch()"
                           @focus="if(searchQuery.trim().length > 0) searchOpen = true"
                           placeholder="Search companies, users, sub IDs, TXNs..." 
                           class="w-full glass-input text-xs text-slate-800 placeholder-slate-400 rounded-2xl pl-10 pr-12 py-2 focus:outline-none transition">
                    
                    <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none">
                        <template x-if="searchLoading">
                            <svg class="animate-spin h-3.5 w-3.5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <template x-if="!searchLoading">
                            <kbd class="px-1.5 py-0.5 text-[10px] font-mono text-slate-500 bg-slate-100 rounded-lg border border-slate-200">⌘K</kbd>
                        </template>
                    </div>
                </div>
            </form>

            <!-- Autocomplete Glass Flyout -->
            <div x-cloak
                 x-show="searchOpen && searchResults && searchQuery.trim().length > 0"
                 x-transition:enter="ease-out duration-150"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="absolute left-0 mt-2 w-full sm:w-[420px] rounded-3xl glass-panel shadow-2xl py-3 z-50 max-h-[460px] overflow-y-auto divide-y divide-slate-100 border border-slate-200/80">
                
                <div class="px-4 pb-2 flex items-center justify-between text-[11px] text-slate-500">
                    <span>Matches for <strong class="text-slate-900" x-text="'&quot;' + searchQuery + '&quot;'"></strong></span>
                    <span class="font-bold text-indigo-600" x-text="(searchResults?.total || 0) + ' found'"></span>
                </div>

                <!-- Companies -->
                <template x-if="searchResults?.companies?.length > 0">
                    <div class="p-2 space-y-1">
                        <div class="px-2 pt-1 text-[10px] font-bold uppercase tracking-wider text-slate-400">Companies</div>
                        <template x-for="item in searchResults.companies" :key="'comp-' + item.id">
                            <a :href="item.url" class="flex items-center justify-between p-2 rounded-xl hover:bg-indigo-50/70 transition group">
                                <div class="truncate">
                                    <p class="text-xs font-bold text-slate-900 group-hover:text-indigo-600 transition truncate" x-text="item.title"></p>
                                    <p class="text-[11px] text-slate-500 truncate" x-text="item.subtitle"></p>
                                </div>
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-bold border border-emerald-200" x-text="item.badge"></span>
                            </a>
                        </template>
                    </div>
                </template>

                <!-- Users -->
                <template x-if="searchResults?.users?.length > 0">
                    <div class="p-2 space-y-1">
                        <div class="px-2 pt-1 text-[10px] font-bold uppercase tracking-wider text-slate-400">Users</div>
                        <template x-for="item in searchResults.users" :key="'usr-' + item.id">
                            <a :href="item.url" class="flex items-center justify-between p-2 rounded-xl hover:bg-indigo-50/70 transition group">
                                <div class="truncate">
                                    <p class="text-xs font-bold text-slate-900 group-hover:text-indigo-600 transition truncate" x-text="item.title"></p>
                                    <p class="text-[11px] text-slate-500 truncate" x-text="item.subtitle"></p>
                                </div>
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 font-bold border border-indigo-200" x-text="item.badge"></span>
                            </a>
                        </template>
                    </div>
                </template>

                <!-- Subscriptions -->
                <template x-if="searchResults?.subscriptions?.length > 0">
                    <div class="p-2 space-y-1">
                        <div class="px-2 pt-1 text-[10px] font-bold uppercase tracking-wider text-slate-400">Subscriptions</div>
                        <template x-for="item in searchResults.subscriptions" :key="'sub-' + item.id">
                            <a :href="item.url" class="flex items-center justify-between p-2 rounded-xl hover:bg-indigo-50/70 transition group">
                                <div class="truncate">
                                    <p class="text-xs font-bold text-indigo-600 truncate" x-text="item.title"></p>
                                    <p class="text-[11px] text-slate-500 truncate" x-text="item.subtitle"></p>
                                </div>
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 font-bold uppercase border border-slate-200" x-text="item.badge"></span>
                            </a>
                        </template>
                    </div>
                </template>

                <!-- Payments -->
                <template x-if="searchResults?.payments?.length > 0">
                    <div class="p-2 space-y-1">
                        <div class="px-2 pt-1 text-[10px] font-bold uppercase tracking-wider text-slate-400">Transactions</div>
                        <template x-for="item in searchResults.payments" :key="'pay-' + item.id">
                            <a :href="item.url" class="flex items-center justify-between p-2 rounded-xl hover:bg-indigo-50/70 transition group">
                                <div class="truncate font-mono">
                                    <p class="text-xs font-bold text-cyan-700 truncate" x-text="item.title"></p>
                                    <p class="text-[11px] text-slate-500 truncate font-sans" x-text="item.subtitle"></p>
                                </div>
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-bold uppercase border border-emerald-200" x-text="item.badge"></span>
                            </a>
                        </template>
                    </div>
                </template>

                <div class="p-2.5 text-center bg-slate-50/80">
                    <a :href="'{{ route('admin.search') }}?q=' + encodeURIComponent(searchQuery)" 
                       class="inline-block text-xs font-bold text-indigo-600 hover:text-indigo-700">
                        View complete query results &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Controls: Fullscreen, Notifications, Profile -->
    <div class="flex items-center gap-2.5 sm:gap-3">
        
        <!-- 4. Fullscreen Glass Button -->
        <button @click="toggleFullscreen()" 
                type="button"
                class="p-2 rounded-2xl glass-card text-slate-600 hover:text-slate-900 transition"
                :title="isFullscreen ? 'Exit Fullscreen' : 'Enter Fullscreen'">
            <svg x-show="!isFullscreen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-5h-4m4 0v4m0-4l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
            </svg>
            <svg x-show="isFullscreen" x-cloak class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9L4 4m0 0v4m0-4h4m6 0h4m0 0v4m0-4l-5 5M9 15l-5 5m0 0h4m-4 0v-4m16 0v4m0 0h-4m4 0l-5-5"/>
            </svg>
        </button>

        <!-- 5. Notifications Glass Flyout -->
        <div class="relative" x-data="{ notifOpen: false }">
            <button @click="notifOpen = !notifOpen" 
                    type="button"
                    class="relative p-2 rounded-2xl glass-card text-slate-600 hover:text-slate-900 transition"
                    title="Platform notifications">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-indigo-600 shadow-[0_0_8px_#6366f1]"></span>
            </button>

            <!-- Notifications Panel -->
            <div x-cloak
                 x-show="notifOpen" 
                 @click.outside="notifOpen = false"
                 class="absolute right-0 mt-2 w-80 sm:w-96 rounded-3xl glass-panel shadow-2xl py-3 z-50 divide-y divide-slate-100 border border-slate-200/80">
                <div class="px-4 pb-2 flex items-center justify-between">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Admin Notifications</h4>
                    <span class="text-[11px] text-indigo-600 font-semibold cursor-pointer hover:underline">Mark all read</span>
                </div>
                <div class="divide-y divide-slate-100 max-h-72 overflow-y-auto">
                    <div class="px-4 py-3 hover:bg-indigo-50/50 transition flex gap-3 cursor-pointer">
                        <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="text-xs">
                            <p class="font-bold text-slate-800">Subscription Renewed</p>
                            <p class="text-slate-500 mt-0.5">CloudScale Labs billed $79.00 via Stripe</p>
                            <span class="text-[10px] text-slate-400 mt-1 block">15 minutes ago</span>
                        </div>
                    </div>
                    <div class="px-4 py-3 hover:bg-indigo-50/50 transition flex gap-3 cursor-pointer">
                        <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 border border-amber-200 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div class="text-xs">
                            <p class="font-bold text-slate-800">Priority Support Ticket</p>
                            <p class="text-slate-500 mt-0.5">SSO SAML login timeout reported by TechFlow</p>
                            <span class="text-[10px] text-slate-400 mt-1 block">1 hour ago</span>
                        </div>
                    </div>
                </div>
                <div class="px-4 pt-2 text-center">
                    <a href="{{ route('admin.activities.index') }}" class="text-xs font-semibold text-slate-600 hover:text-indigo-600 transition">View all activity audit logs &rarr;</a>
                </div>
            </div>
        </div>

        <!-- 6. Profile Avatar & Dropdown -->
        <div class="relative" x-data="{ profileMenu: false }">
            <button @click="profileMenu = !profileMenu" 
                    type="button"
                    class="flex items-center gap-2.5 p-1 rounded-2xl glass-card hover:bg-slate-100/70 transition">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-indigo-500 via-indigo-600 to-purple-600 flex items-center justify-center text-white font-black text-xs shadow-md shadow-indigo-600/20 border border-white/40">
                    {{ substr(Auth::user()?->name ?? 'SA', 0, 2) }}
                </div>
                
                <div class="hidden sm:block text-left text-xs pr-1">
                    <span class="block font-bold text-slate-900">{{ Auth::user()?->name ?? 'Super Admin' }}</span>
                    <span class="block text-[9px] text-indigo-600 font-bold uppercase tracking-wide">Platform Owner</span>
                </div>

                <svg class="w-3.5 h-3.5 text-slate-400 hidden sm:block transition-transform duration-200" 
                     :class="profileMenu ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <!-- Profile Flyout -->
            <div x-cloak
                 x-show="profileMenu" 
                 @click.outside="profileMenu = false"
                 x-transition:enter="ease-out duration-150"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="absolute right-0 mt-2 w-56 rounded-3xl glass-panel shadow-2xl py-2 z-50 border border-slate-200/80">
                
                <div class="px-4 py-2.5 border-b border-slate-100">
                    <p class="text-xs font-bold text-slate-900">{{ Auth::user()?->name ?? 'Super Admin' }}</p>
                    <p class="text-[11px] text-slate-500 truncate">{{ Auth::user()?->email ?? 'admin@nexora.test' }}</p>
                    <span class="inline-block mt-1 px-1.5 py-0.5 rounded text-[9px] font-bold uppercase bg-indigo-50 text-indigo-700 border border-indigo-200">Super Administrator</span>
                </div>

                <a href="{{ route('admin.users.index', ['search' => Auth::user()?->email]) }}" class="flex items-center gap-2.5 px-4 py-2 text-xs text-slate-700 hover:bg-indigo-50/70 hover:text-indigo-600 transition font-medium">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>My Profile</span>
                </a>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs text-slate-700 hover:bg-indigo-50/70 hover:text-indigo-600 transition font-medium">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Platform Settings</span>
                </a>

                <a href="{{ route('admin.activities.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs text-slate-700 hover:bg-indigo-50/70 hover:text-indigo-600 transition font-medium">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Audit Logs</span>
                </a>

                <div class="border-t border-slate-100 my-1"></div>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition text-left font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>