@extends('layouts.super-admin')

@section('title', 'Registered Companies & Tenants')

@section('content')
<div class="space-y-6">
    <div class="glass-panel rounded-3xl p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Companies Management</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Tenant directory, workspace isolation, domains, and access states.</p>
        </div>
        <div class="text-xs text-slate-500">Total: <strong class="text-slate-900">{{ $companies->total() }} tenants</strong></div>
    </div>

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('admin.companies.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search company by name, slug, domain, or email..." 
               class="flex-1 w-full glass-input rounded-2xl px-4 py-2.5 text-xs text-slate-900 placeholder-slate-400 focus:outline-none">
        <select name="status" onchange="this.form.submit()" class="glass-input rounded-2xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none">
            <option value="">All Statuses</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
        </select>
        <button type="submit" class="px-5 py-2.5 rounded-2xl text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white transition shadow-lg shadow-indigo-600/30">
            Filter
        </button>
    </form>

    <!-- Table -->
    <div class="glass-panel rounded-3xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200/80 text-slate-500 uppercase tracking-wider font-bold bg-slate-50/70">
                        <th class="py-3.5 px-4">Company</th>
                        <th class="py-3.5 px-4">Subdomain / Domain</th>
                        <th class="py-3.5 px-4">Plan</th>
                        <th class="py-3.5 px-4">Users</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Created Date</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($companies as $company)
                        <tr class="hover:bg-indigo-50/30 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-900 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-black shadow-sm shrink-0 border border-white/40">
                                    {{ substr($company->name, 0, 2) }}
                                </div>
                                <div>
                                    <div class="text-slate-900 font-bold">{{ $company->name }}</div>
                                    <div class="text-[11px] text-slate-500 font-normal">{{ $company->email ?? 'No email' }}</div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 font-mono text-[11px]">
                                {{ $company->domain ?? $company->slug . '.nexora.app' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-xl bg-indigo-50 border border-indigo-200 text-indigo-700 font-bold text-[11px]">
                                    {{ $company->activeSubscription->plan->name ?? 'Custom Plan' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-800 font-bold">
                                {{ $company->users->count() }} members
                            </td>
                            <td class="py-3.5 px-4">
                                @if($company->status === 'active')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Active
                                    </span>
                                @elseif($company->status === 'suspended')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200"
                                          title="{{ $company->suspension_reason ?? 'Suspended by admin' }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Suspended
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 font-mono text-[11px]">
                                {{ $company->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('admin.companies.show', $company->id) }}" class="px-3 py-1.5 rounded-xl glass-card hover:bg-indigo-50 text-indigo-600 hover:text-indigo-800 transition font-bold">
                                    Manage &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 italic">No companies found matching criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200/70">
            {{ $companies->links() }}
        </div>
    </div>
</div>
@endsection