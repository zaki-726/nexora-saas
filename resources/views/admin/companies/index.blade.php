@extends('layouts.admin')

@section('title', 'Registered Companies & Tenants')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-800/80">
        <div>
            <h1 class="text-2xl font-black text-white tracking-tight">Companies Management</h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Manage registered companies, active subscription tiers, and domains.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs text-slate-400">Total: <strong class="text-white">{{ $companies->total() }} tenants</strong></span>
        </div>
    </div>

    <!-- Filter / Search Bar -->
    <form method="GET" action="{{ route('admin.companies.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
        <div class="relative flex-1 w-full">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search company by name, slug, or email..." 
                   class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500">
        </div>
        <select name="status" onchange="this.form.submit()" class="bg-slate-900 border border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-300 focus:outline-none focus:border-indigo-500">
            <option value="">All Statuses</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
        </select>
        <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl text-xs font-semibold bg-indigo-600 hover:bg-indigo-500 text-white transition">Filter</button>
    </form>

    <!-- Table -->
    <div class="bg-slate-900/80 border border-slate-800 rounded-3xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-950/40 text-slate-400 uppercase tracking-wider border-b border-slate-800/80 font-semibold">
                        <th class="py-3.5 px-4">Company</th>
                        <th class="py-3.5 px-4">Subdomain / Domain</th>
                        <th class="py-3.5 px-4">Plan</th>
                        <th class="py-3.5 px-4">Users</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Created Date</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/40 text-slate-300">
                    @forelse($companies as $company)
                        <tr class="hover:bg-slate-850/40 transition">
                            <td class="py-3.5 px-4 font-bold text-white flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-black shadow shrink-0">
                                    {{ substr($company->name, 0, 2) }}
                                </div>
                                <div>
                                    <div class="text-white font-bold">{{ $company->name }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $company->email ?? 'No email' }}</div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-400 font-mono text-[11px]">
                                {{ $company->domain ?? $company->slug . '.nexora.app' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-lg bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 font-semibold text-[11px]">
                                    {{ $company->activeSubscription->plan->name ?? 'No Plan' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-300 font-semibold">
                                {{ $company->users->count() }} members
                            </td>
                            <td class="py-3.5 px-4">
                                @if($company->status === 'active')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                        Active
                                    </span>
                                @elseif($company->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                        Suspended
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-400">
                                {{ $company->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('admin.companies.show', $company) }}" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-indigo-400 hover:text-white transition font-semibold">
                                    Manage &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">No companies found matching criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-800">
            {{ $companies->links() }}
        </div>
    </div>
</div>
@endsection
