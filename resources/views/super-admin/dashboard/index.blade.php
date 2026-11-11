@extends('layouts.super-admin')

@section('title', 'Super Admin Console & Multi-Tenant Analytics')

@section('content')
<div class="space-y-6">

    <!-- Top Greeting & Action Header (Gracious Light Glass) -->
    <div class="glass-panel rounded-3xl p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Super Admin Dashboard</h1>
                <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200 flex items-center gap-1.5 shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-ping"></span>
                    Live Sync &bull; Gracious Glass
                </span>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Unified multi-tenant orchestration: tenant lifecycles, active subscriptions, revenue tracking, and security audit logs.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.plans.index') }}" 
               class="px-3.5 py-2 rounded-2xl text-xs font-semibold glass-card hover:bg-slate-100/80 text-slate-700 transition flex items-center gap-1.5">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                <span>New Plan</span>
            </a>

            <a href="{{ route('admin.announcements.index') }}" 
               class="px-4 py-2 rounded-2xl text-xs font-bold bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white shadow-lg shadow-indigo-600/25 border border-white/40 transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                <span>Broadcast Alert</span>
            </a>
        </div>
    </div>

    <!-- 1. Statistics Cards Partial -->
    @include('super-admin.dashboard.partials.statistics')

    <!-- 2. Analytics Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Revenue Analytics Line Chart (2 Cols) -->
        <div class="lg:col-span-2">
            @include('super-admin.dashboard.partials.revenue-chart')
        </div>

        <!-- Subscription Doughnut Chart (1 Col) -->
        <div class="lg:col-span-1">
            @include('super-admin.dashboard.partials.subscription-chart')
        </div>
    </div>

    <!-- 3. Recent Registered Companies Table (Section 7) -->
    @include('super-admin.dashboard.partials.recent-companies')

    <!-- 4. Recent Transactions & Activity Logs Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Transactions (2 Cols) -->
        <div class="lg:col-span-2">
            @include('super-admin.dashboard.partials.recent-transactions')
        </div>

        <!-- Recent Activities Timeline (1 Col) -->
        <div class="lg:col-span-1">
            @include('super-admin.dashboard.partials.recent-activities')
        </div>
    </div>

</div>
@endsection