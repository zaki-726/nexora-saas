@extends('layouts.super-admin')

@section('title', 'Company: ' . $company->name)

@section('content')
<div class="space-y-6" x-data="{ suspendModalOpen: false, suspensionReason: '' }">
    <!-- Header -->
    <div class="glass-panel rounded-3xl p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.companies.index') }}" class="p-2.5 rounded-2xl glass-card text-slate-600 hover:text-slate-900 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-900 flex items-center gap-3">
                    <span>{{ $company->name }}</span>
                    @if($company->status === 'active')
                        <span class="text-xs uppercase px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold">Active Tenant</span>
                    @elseif($company->status === 'suspended')
                        <span class="text-xs uppercase px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-700 border border-rose-200 font-bold">Suspended</span>
                    @else
                        <span class="text-xs uppercase px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200 font-bold">Pending</span>
                    @endif
                </h1>
                <p class="text-xs text-slate-500 mt-1">Tenant Slug: <span class="font-mono text-indigo-600 font-bold">{{ $company->slug }}</span> &bull; Domain: <span class="font-mono text-cyan-700 font-semibold">{{ $company->domain ?? $company->slug . '.nexora.app' }}</span></p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            @if($company->status === 'suspended')
                <form method="POST" action="{{ route('admin.companies.activate', $company->id) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-2xl text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white shadow-lg shadow-emerald-600/30 transition">
                        Reactivate Tenant
                    </button>
                </form>
            @else
                <button type="button" @click="suspendModalOpen = true" class="px-4 py-2 rounded-2xl text-xs font-bold bg-rose-600 hover:bg-rose-700 text-white shadow-lg shadow-rose-600/30 transition">
                    Suspend Tenant
                </button>
            @endif
        </div>
    </div>

    @if($company->status === 'suspended')
        <div class="glass-panel p-4 rounded-3xl border border-rose-200 bg-rose-50/70 text-xs text-rose-800">
            <strong>Suspension Notice:</strong> Suspended on {{ $company->suspended_at?->format('M d, Y H:i') ?? 'Recently' }}. Reason: "{{ $company->suspension_reason ?? 'Administrative freeze' }}". Tenant workspace access is locked.
        </div>
    @endif

    <!-- Profile & Metrics Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- 1. Profile & Owner -->
        <div class="glass-panel rounded-3xl p-6 space-y-4">
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-200/70 pb-2">Tenant Profile & Owner</h3>
            <div class="text-xs space-y-3 text-slate-600">
                <div class="flex justify-between"><span class="text-slate-500">Company Owner:</span> <span class="text-slate-900 font-bold">{{ $company->owner->name ?? ($company->users->first()?->name ?? 'N/A') }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Owner Email:</span> <span class="text-indigo-600 font-mono font-bold">{{ $company->owner->email ?? ($company->email ?? 'N/A') }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Phone:</span> <span class="text-slate-900">{{ $company->phone ?? 'N/A' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Address:</span> <span class="text-slate-900 text-right max-w-[200px]">{{ $company->address ?? 'N/A' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Registered:</span> <span class="text-slate-900 font-mono">{{ $company->created_at->format('M d, Y') }}</span></div>
            </div>
        </div>

        <!-- 2. Current Subscription -->
        <div class="glass-panel rounded-3xl p-6 space-y-4">
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-200/70 pb-2">Subscription Lifecyle</h3>
            @php $sub = $company->subscriptions->first(); @endphp
            @if($sub)
                <div class="text-xs space-y-3 text-slate-600">
                    <div class="flex justify-between"><span class="text-slate-500">Active Tier:</span> <span class="text-indigo-600 font-bold">{{ $sub->plan->name ?? 'Custom' }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Price:</span> <span class="text-slate-900 font-bold font-mono">${{ number_format($sub->plan->price ?? 0, 2) }}/mo</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Status:</span> <span class="text-emerald-700 font-bold uppercase">{{ $sub->status }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Renewal Date:</span> <span class="text-slate-900 font-mono">{{ $sub->current_period_end?->format('M d, Y') ?? 'Auto-renew' }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Trial Ends:</span> <span class="text-slate-500 font-mono">{{ $sub->trial_ends_at?->format('M d, Y') ?? 'N/A' }}</span></div>
                </div>
            @else
                <p class="text-xs text-slate-400 py-4">No subscription registered.</p>
            @endif
        </div>

        <!-- 3. Usage & Billing Summary -->
        <div class="glass-panel rounded-3xl p-6 space-y-4">
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-200/70 pb-2">Platform Activity & Revenue</h3>
            <div class="text-xs space-y-3 text-slate-600">
                <div class="flex justify-between"><span class="text-slate-500">Total Team Users:</span> <span class="text-slate-900 font-bold">{{ $company->users->count() }} seats</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Total Lifetime Payments:</span> <span class="text-emerald-700 font-bold font-mono">${{ number_format($company->payments->sum('amount'), 2) }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Invoices Generated:</span> <span class="text-slate-900 font-semibold">{{ $company->invoices->count() }} records</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Support Incidents:</span> <span class="text-amber-700 font-bold">{{ $company->tickets->count() }} tickets</span></div>
            </div>
        </div>
    </div>

    <!-- Company Users -->
    <div class="glass-panel rounded-3xl p-6 shadow-xl space-y-4">
        <h3 class="text-sm font-bold text-slate-900">All Company Users ({{ $company->users->count() }})</h3>
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="text-slate-500 uppercase tracking-wider border-b border-slate-200/80 pb-2 font-bold bg-slate-50/70">
                    <th class="py-2.5 px-3">Name</th>
                    <th class="py-2.5 px-3">Email</th>
                    <th class="py-2.5 px-3">Role</th>
                    <th class="py-2.5 px-3">Status</th>
                    <th class="py-2.5 px-3">Joined</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @foreach($company->users as $u)
                    <tr class="hover:bg-indigo-50/30 transition">
                        <td class="py-2.5 px-3 font-bold text-slate-900">{{ $u->name }}</td>
                        <td class="py-2.5 px-3 text-slate-500 font-mono">{{ $u->email }}</td>
                        <td class="py-2.5 px-3"><span class="px-2 py-0.5 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-semibold">{{ $u->role }}</span></td>
                        <td class="py-2.5 px-3"><span class="text-emerald-700 font-bold">{{ ucfirst($u->status) }}</span></td>
                        <td class="py-2.5 px-3 text-slate-500 font-mono">{{ $u->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Payment History -->
    <div class="glass-panel rounded-3xl p-6 shadow-xl space-y-4">
        <h3 class="text-sm font-bold text-slate-900">Payment & Billing History</h3>
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="text-slate-500 uppercase tracking-wider border-b border-slate-200/80 pb-2 font-bold bg-slate-50/70">
                    <th class="py-2.5 px-3">Transaction ID</th>
                    <th class="py-2.5 px-3">Amount</th>
                    <th class="py-2.5 px-3">Gateway</th>
                    <th class="py-2.5 px-3">Status</th>
                    <th class="py-2.5 px-3">Settlement Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($company->payments as $p)
                    <tr class="hover:bg-indigo-50/30 transition">
                        <td class="py-2.5 px-3 font-mono font-bold text-indigo-600">{{ $p->transaction_id }}</td>
                        <td class="py-2.5 px-3 font-mono font-bold text-slate-900">${{ number_format($p->amount, 2) }}</td>
                        <td class="py-2.5 px-3 capitalize text-slate-600 font-medium">{{ $p->payment_method }}</td>
                        <td class="py-2.5 px-3">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase">{{ $p->status }}</span>
                        </td>
                        <td class="py-2.5 px-3 text-slate-500 font-mono">{{ $p->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-slate-400 italic">No payments on record.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Suspend Confirmation Modal -->
    <div x-cloak
         x-show="suspendModalOpen"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-md">
        <div class="glass-panel w-full max-w-lg rounded-3xl p-6 shadow-2xl border border-rose-200/80 space-y-4"
             @click.outside="suspendModalOpen = false">
            <h3 class="text-base font-bold text-slate-900">Suspend {{ $company->name }}</h3>
            <p class="text-xs text-slate-600">Provide an explicit suspension reason. Workspace features will be frozen.</p>
            <form action="{{ route('admin.companies.suspend', $company->id) }}" method="POST" class="space-y-4">
                @csrf
                <textarea name="reason" x-model="suspensionReason" required rows="3" placeholder="Suspension reason..."
                          class="w-full glass-input rounded-2xl p-3 text-xs text-slate-900 placeholder-slate-400 focus:outline-none"></textarea>
                <div class="flex items-center justify-end gap-2">
                    <button type="button" @click="suspendModalOpen = false" class="px-4 py-2 rounded-xl glass-card text-xs font-bold text-slate-600 hover:text-slate-900">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold bg-rose-600 hover:bg-rose-700 text-white shadow-md shadow-rose-600/30">Confirm Suspension</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection