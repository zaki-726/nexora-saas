@extends('layouts.admin')

@section('title', 'Company Details: ' . $company->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.companies.index') }}" class="p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-black text-white flex items-center gap-3">
                    <span>{{ $company->name }}</span>
                    <span class="text-xs uppercase px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-bold">{{ $company->status }}</span>
                </h1>
                <p class="text-xs text-slate-400 mt-0.5">Tenant Slug: <span class="font-mono text-indigo-400">{{ $company->slug }}</span> | Subdomain: <span class="font-mono text-cyan-400">{{ $company->domain ?? $company->slug . '.nexora.app' }}</span></p>
            </div>
        </div>
    </div>

    <!-- Company Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Overview Card -->
        <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-5 space-y-4">
            <h3 class="text-sm font-bold text-white border-b border-slate-800 pb-2">Tenant Profile</h3>
            <div class="text-xs space-y-2.5">
                <div class="flex justify-between"><span class="text-slate-400">Company Email:</span> <span class="text-white font-medium">{{ $company->email ?? 'N/A' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">Phone:</span> <span class="text-white font-medium">{{ $company->phone ?? 'N/A' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">Address:</span> <span class="text-white font-medium text-right max-w-[200px]">{{ $company->address ?? 'N/A' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">Registered:</span> <span class="text-white font-medium">{{ $company->created_at->format('M d, Y') }}</span></div>
            </div>
        </div>

        <!-- Subscription Card -->
        <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-5 space-y-4">
            <h3 class="text-sm font-bold text-white border-b border-slate-800 pb-2">Active Subscription</h3>
            @php $sub = $company->subscriptions->first(); @endphp
            @if($sub)
                <div class="text-xs space-y-2.5">
                    <div class="flex justify-between"><span class="text-slate-400">Plan:</span> <span class="text-indigo-400 font-bold">{{ $sub->plan->name ?? 'Custom' }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Price:</span> <span class="text-white font-bold">${{ number_format($sub->plan->price ?? 0, 2) }}/mo</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Status:</span> <span class="text-emerald-400 font-bold uppercase">{{ $sub->status }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Current Period End:</span> <span class="text-white">{{ $sub->current_period_end?->format('M d, Y') ?? 'Auto-renew' }}</span></div>
                </div>
            @else
                <p class="text-xs text-slate-400">No active subscription recorded for this tenant.</p>
            @endif
        </div>

        <!-- Team Stats Card -->
        <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-5 space-y-4">
            <h3 class="text-sm font-bold text-white border-b border-slate-800 pb-2">Team & Usage</h3>
            <div class="text-xs space-y-2.5">
                <div class="flex justify-between"><span class="text-slate-400">Total Users:</span> <span class="text-white font-bold">{{ $company->users->count() }} members</span></div>
                <div class="flex justify-between"><span class="text-slate-400">Total Payments:</span> <span class="text-white font-bold">${{ number_format($company->payments->sum('amount'), 2) }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">Open Tickets:</span> <span class="text-amber-400 font-bold">{{ $company->tickets->where('status', 'open')->count() }} open</span></div>
            </div>
        </div>
    </div>

    <!-- Company Users -->
    <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-5 shadow-xl">
        <h3 class="text-sm font-bold text-white mb-4">Assigned Tenant Users</h3>
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="text-slate-400 uppercase tracking-wider border-b border-slate-800 pb-2">
                    <th class="pb-2">Name</th>
                    <th class="pb-2">Email</th>
                    <th class="pb-2">Role</th>
                    <th class="pb-2">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/40 text-slate-300">
                @foreach($company->users as $u)
                    <tr class="hover:bg-slate-850/40">
                        <td class="py-2.5 font-bold text-white">{{ $u->name }}</td>
                        <td class="py-2.5">{{ $u->email }}</td>
                        <td class="py-2.5"><span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300 text-[11px] font-semibold">{{ $u->role }}</span></td>
                        <td class="py-2.5"><span class="text-emerald-400">{{ ucfirst($u->status) }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
