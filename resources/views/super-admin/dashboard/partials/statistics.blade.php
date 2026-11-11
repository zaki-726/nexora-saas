<!-- 4. Dashboard Statistics Cards (6 Core Metrics - Gracious Light Glass) -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">
    
    <!-- Card 1: Total Companies -->
    <a href="{{ route('admin.companies.index') }}" 
       class="glass-panel glass-panel-hover rounded-3xl p-4.5 flex flex-col justify-between group relative overflow-hidden">
        <div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Total Companies</span>
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 border border-blue-200 flex items-center justify-center group-hover:scale-110 transition-transform shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-1.5">
                <span class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($totalCompanies) }}</span>
                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded-full border border-emerald-200">
                    +{{ $companiesGrowth }}%
                </span>
            </div>
        </div>
        <div class="mt-3 pt-2.5 border-t border-slate-200/70 text-[11px] text-slate-500 flex items-center justify-between">
            <span>All registered tenants</span>
            <span class="text-slate-400 group-hover:text-blue-600 transition">&rarr;</span>
        </div>
    </a>

    <!-- Card 2: Total Users -->
    <a href="{{ route('admin.users.index') }}" 
       class="glass-panel glass-panel-hover rounded-3xl p-4.5 flex flex-col justify-between group relative overflow-hidden">
        <div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Total Users</span>
                <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 border border-purple-200 flex items-center justify-center group-hover:scale-110 transition-transform shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-1.5">
                <span class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($totalUsers) }}</span>
                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded-full border border-emerald-200">
                    +{{ $usersGrowth }}%
                </span>
            </div>
        </div>
        <div class="mt-3 pt-2.5 border-t border-slate-200/70 text-[11px] text-slate-500 flex items-center justify-between">
            <span>All platform accounts</span>
            <span class="text-slate-400 group-hover:text-purple-600 transition">&rarr;</span>
        </div>
    </a>

    <!-- Card 3: Active Subscriptions -->
    <a href="{{ route('admin.subscriptions.index') }}" 
       class="glass-panel glass-panel-hover rounded-3xl p-4.5 flex flex-col justify-between group relative overflow-hidden">
        <div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Active Subscriptions</span>
                <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-200 flex items-center justify-center group-hover:scale-110 transition-transform shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-1.5">
                <span class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($activeSubscriptions) }}</span>
                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded-full border border-emerald-200">
                    +{{ $subsGrowth }}%
                </span>
            </div>
        </div>
        <div class="mt-3 pt-2.5 border-t border-slate-200/70 text-[11px] text-slate-500 flex items-center justify-between">
            <span>Currently active</span>
            <span class="text-slate-400 group-hover:text-indigo-600 transition">&rarr;</span>
        </div>
    </a>

    <!-- Card 4: Monthly Revenue -->
    <a href="{{ route('admin.payments.index') }}" 
       class="glass-panel glass-panel-hover rounded-3xl p-4.5 flex flex-col justify-between group relative overflow-hidden">
        <div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Monthly Revenue</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center group-hover:scale-110 transition-transform shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-1.5">
                <span class="text-2xl font-black text-slate-900 tracking-tight">${{ number_format($monthlyRevenue, 0) }}</span>
                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded-full border border-emerald-200">
                    +{{ $revenueGrowth }}%
                </span>
            </div>
        </div>
        <div class="mt-3 pt-2.5 border-t border-slate-200/70 text-[11px] text-slate-500 flex items-center justify-between">
            <span>Gross volume (USD)</span>
            <span class="text-slate-400 group-hover:text-emerald-600 transition">&rarr;</span>
        </div>
    </a>

    <!-- Card 5: Pending Payments -->
    <a href="{{ route('admin.payments.index', ['status' => 'pending']) }}" 
       class="glass-panel glass-panel-hover rounded-3xl p-4.5 flex flex-col justify-between group relative overflow-hidden">
        <div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Pending Payments</span>
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 border border-amber-200 flex items-center justify-center group-hover:scale-110 transition-transform shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-1.5">
                <span class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($pendingPayments) }}</span>
                @if($pendingPayments > 0)
                    <span class="text-[10px] font-bold text-amber-700 bg-amber-50 px-1.5 py-0.5 rounded-full border border-amber-200">Action Req.</span>
                @else
                    <span class="text-[10px] font-semibold text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded-full border border-slate-200">Settled</span>
                @endif
            </div>
        </div>
        <div class="mt-3 pt-2.5 border-t border-slate-200/70 text-[11px] text-slate-500 flex items-center justify-between">
            <span>Awaiting resolution</span>
            <span class="text-slate-400 group-hover:text-amber-600 transition">&rarr;</span>
        </div>
    </a>

    <!-- Card 6: Open Tickets -->
    <a href="{{ route('admin.tickets.index', ['status' => 'open']) }}" 
       class="glass-panel glass-panel-hover rounded-3xl p-4.5 flex flex-col justify-between group relative overflow-hidden">
        <div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Open Tickets</span>
                <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 border border-rose-200 flex items-center justify-center group-hover:scale-110 transition-transform shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-1.5">
                <span class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($openTickets) }}</span>
                @if($urgentTickets > 0)
                    <span class="text-[10px] font-bold text-rose-700 bg-rose-50 px-1.5 py-0.5 rounded-full border border-rose-200 animate-pulse">
                        {{ $urgentTickets }} Urgent
                    </span>
                @else
                    <span class="text-[10px] font-semibold text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded-full border border-slate-200">Normal</span>
                @endif
            </div>
        </div>
        <div class="mt-3 pt-2.5 border-t border-slate-200/70 text-[11px] text-slate-500 flex items-center justify-between">
            <span>Customer support queue</span>
            <span class="text-slate-400 group-hover:text-rose-600 transition">&rarr;</span>
        </div>
    </a>

</div>