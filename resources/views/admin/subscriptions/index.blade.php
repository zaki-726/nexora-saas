@extends('layouts.admin')

@section('title', 'Active Subscriptions')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between pb-2 border-b border-slate-800">
        <div>
            <h1 class="text-2xl font-black text-white tracking-tight">Active Subscriptions</h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Tenant subscription lifecycles, renewal dates, and statuses.</p>
        </div>
        <div class="text-xs text-slate-400">Total: <strong class="text-white">{{ $subscriptions->total() }}</strong></div>
    </div>

    <div class="bg-slate-900/80 border border-slate-800 rounded-3xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-950/40 text-slate-400 uppercase tracking-wider border-b border-slate-800/80 font-semibold">
                        <th class="py-3.5 px-4">Company</th>
                        <th class="py-3.5 px-4">Current Plan</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Period Start</th>
                        <th class="py-3.5 px-4">Renewal / End Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/40 text-slate-300">
                    @forelse($subscriptions as $sub)
                        <tr class="hover:bg-slate-850/40 transition">
                            <td class="py-3.5 px-4 font-bold text-white">{{ $sub->company->name ?? 'N/A' }}</td>
                            <td class="py-3.5 px-4 text-indigo-400 font-bold">{{ $sub->plan->name ?? 'Custom' }} (${{ number_format($sub->plan->price ?? 0) }}/mo)</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 uppercase">
                                    {{ $sub->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-400">{{ $sub->current_period_start?->format('M d, Y') ?? 'N/A' }}</td>
                            <td class="py-3.5 px-4 text-slate-400">{{ $sub->current_period_end?->format('M d, Y') ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">No subscriptions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-800">
            {{ $subscriptions->links() }}
        </div>
    </div>
</div>
@endsection
