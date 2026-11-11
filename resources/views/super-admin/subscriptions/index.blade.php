@extends('layouts.super-admin')

@section('title', 'Active Subscriptions')

@section('content')
<div class="space-y-6">
    <div class="glass-panel rounded-3xl p-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Active Subscriptions</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Tenant subscription lifecycles, renewal dates, and statuses.</p>
        </div>
        <div class="text-xs text-slate-500">Total: <strong class="text-slate-900">{{ $subscriptions->total() }}</strong></div>
    </div>

    <div class="glass-panel rounded-3xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200/80 text-slate-500 uppercase tracking-wider font-bold bg-slate-50/70">
                        <th class="py-3.5 px-4">Company</th>
                        <th class="py-3.5 px-4">Current Plan</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Period Start</th>
                        <th class="py-3.5 px-4">Renewal Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($subscriptions as $sub)
                        <tr class="hover:bg-indigo-50/30 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-900">{{ $sub->company->name ?? 'N/A' }}</td>
                            <td class="py-3.5 px-4 text-indigo-700 font-bold">{{ $sub->plan->name ?? 'Custom' }} (${{ number_format($sub->plan->price ?? 0) }}/mo)</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase">
                                    {{ $sub->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 font-mono">{{ $sub->current_period_start?->format('M d, Y') ?? 'N/A' }}</td>
                            <td class="py-3.5 px-4 text-slate-500 font-mono">{{ $sub->current_period_end?->format('M d, Y') ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 italic">No subscriptions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200/70">
            {{ $subscriptions->links() }}
        </div>
    </div>
</div>
@endsection