@extends('layouts.super-admin')

@section('title', 'Global Platform Search: ' . ($query ?: 'All'))

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="glass-panel rounded-3xl p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>Global Database Search</span>
                @if($query)
                    <span class="text-xs font-mono font-bold text-indigo-700 bg-indigo-50 border border-indigo-200 px-2.5 py-0.5 rounded-lg">
                        "{{ $query }}"
                    </span>
                @endif
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Realtime database query results across companies, users, subscription records, and transaction IDs.
            </p>
        </div>
        <div class="text-xs text-slate-500">
            Total Matches: <strong class="text-slate-900">{{ $totalResults }}</strong>
        </div>
    </div>

    <!-- Live Search Input Form -->
    <form method="GET" action="{{ route('admin.search') }}" class="relative max-w-2xl">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <input type="text" name="q" value="{{ $query }}" placeholder="Search company, user name, email, subscription ID (#1), or TXN reference..." autofocus
               class="w-full glass-input rounded-3xl pl-12 pr-24 py-3.5 text-xs text-slate-900 placeholder-slate-400 focus:outline-none shadow-xl transition">
        <button type="submit" class="absolute inset-y-2 right-2 px-4 rounded-2xl text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white transition flex items-center gap-1.5 shadow-md">
            <span>Query DB</span>
        </button>
    </form>

    @if($totalResults === 0 && !empty($query))
        <div class="glass-panel rounded-3xl p-12 text-center">
            <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 mx-auto mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-base font-bold text-slate-900">No Database Matches Found</h3>
            <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                No company name, user email, subscription ID, or transaction reference matched <strong class="text-indigo-600">"{{ $query }}"</strong>.
            </p>
        </div>
    @endif

    <!-- Results Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- 1. Matching Companies -->
        <div class="glass-panel rounded-3xl p-5 shadow-2xl space-y-3">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200/70">
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Companies (Tenants)</span>
                </h3>
                <span class="text-xs font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200">
                    {{ $companies->count() }}
                </span>
            </div>

            <div class="space-y-2">
                @forelse($companies as $c)
                    <a href="{{ route('admin.companies.show', $c->id) }}" class="flex items-center justify-between p-3 rounded-2xl bg-white/70 hover:bg-indigo-50/70 border border-slate-200/80 transition group">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 text-white font-black text-xs flex items-center justify-center shrink-0 border border-white/40">
                                {{ substr($c->name, 0, 2) }}
                            </div>
                            <div class="truncate">
                                <p class="text-xs font-bold text-slate-900 group-hover:text-indigo-600 transition truncate">{{ $c->name }}</p>
                                <p class="text-[11px] text-slate-500 font-mono truncate">{{ $c->domain ?? ($c->slug . '.nexora.app') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase">{{ $c->status }}</span>
                            <span class="text-slate-400 group-hover:text-indigo-600 transition">&rarr;</span>
                        </div>
                    </a>
                @empty
                    <p class="text-xs text-slate-400 italic py-3 text-center">No matching companies.</p>
                @endforelse
            </div>
        </div>

        <!-- 2. Matching Users -->
        <div class="glass-panel rounded-3xl p-5 shadow-2xl space-y-3">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200/70">
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span>Platform Users</span>
                </h3>
                <span class="text-xs font-bold text-purple-700 bg-purple-50 px-2 py-0.5 rounded-full border border-purple-200">
                    {{ $users->count() }}
                </span>
            </div>

            <div class="space-y-2">
                @forelse($users as $u)
                    <div class="flex items-center justify-between p-3 rounded-2xl bg-white/70 border border-slate-200/80">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-700 font-bold text-xs flex items-center justify-center shrink-0 border border-indigo-200">
                                {{ substr($u->name, 0, 2) }}
                            </div>
                            <div class="truncate">
                                <p class="text-xs font-bold text-slate-900 truncate">{{ $u->name }}</p>
                                <p class="text-[11px] text-slate-500 truncate font-mono">{{ $u->email }}</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 border border-slate-200 uppercase">
                            {{ str_replace('_', ' ', $u->role) }}
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 italic py-3 text-center">No matching users.</p>
                @endforelse
            </div>
        </div>

        <!-- 3. Matching Subscriptions -->
        <div class="glass-panel rounded-3xl p-5 shadow-2xl space-y-3">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200/70">
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    <span>Subscription Records</span>
                </h3>
                <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                    {{ $subscriptions->count() }}
                </span>
            </div>

            <div class="space-y-2">
                @forelse($subscriptions as $s)
                    <div class="flex items-center justify-between p-3 rounded-2xl bg-white/70 border border-slate-200/80">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-xs font-bold text-indigo-600">Sub #{{ $s->id }}</span>
                                <span class="text-xs font-bold text-slate-900">&bull; {{ $s->company->name ?? 'Company' }}</span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-0.5">{{ $s->plan->name ?? 'Custom Plan' }} (${{ number_format($s->plan->price ?? 0) }}/mo)</p>
                        </div>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase">
                            {{ $s->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 italic py-3 text-center">No matching subscription IDs.</p>
                @endforelse
            </div>
        </div>

        <!-- 4. Matching Transactions -->
        <div class="glass-panel rounded-3xl p-5 shadow-2xl space-y-3">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200/70">
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Transactions / Payments</span>
                </h3>
                <span class="text-xs font-bold text-cyan-700 bg-cyan-50 px-2 py-0.5 rounded-full border border-cyan-200">
                    {{ $payments->count() }}
                </span>
            </div>

            <div class="space-y-2">
                @forelse($payments as $p)
                    <div class="flex items-center justify-between p-3 rounded-2xl bg-white/70 border border-slate-200/80">
                        <div>
                            <span class="font-mono text-xs font-bold text-cyan-700">{{ $p->transaction_id }}</span>
                            <p class="text-[11px] text-slate-500 mt-0.5">{{ $p->company->name ?? 'Company' }} &bull; {{ ucfirst($p->payment_method) }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-black text-slate-900 font-mono">${{ number_format($p->amount, 2) }}</span>
                            <span class="block text-[10px] uppercase font-bold {{ $p->status === 'paid' || $p->status === 'succeeded' ? 'text-emerald-700' : 'text-amber-700' }}">
                                {{ $p->status }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 italic py-3 text-center">No matching transaction references.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection