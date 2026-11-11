@extends('layouts.super-admin')

@section('title', 'Platform Payments & Transactions')

@section('content')
<div class="space-y-6">
    <div class="glass-panel rounded-3xl p-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Payments & Transactions</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Audit log of all settled, pending, and refunded payment transactions.</p>
        </div>
        <div class="text-xs text-slate-500">Total: <strong class="text-slate-900">{{ $payments->total() }}</strong></div>
    </div>

    <!-- Filter -->
    <form method="GET" action="{{ route('admin.payments.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Transaction ID or Company..." 
               class="flex-1 w-full glass-input rounded-2xl px-4 py-2.5 text-xs text-slate-900 placeholder-slate-400 focus:outline-none">
        <select name="status" onchange="this.form.submit()" class="glass-input rounded-2xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none">
            <option value="">All Statuses</option>
            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
            <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
        </select>
        <button type="submit" class="px-5 py-2.5 rounded-2xl text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white transition shadow-lg shadow-indigo-600/30">Filter</button>
    </form>

    <div class="glass-panel rounded-3xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200/80 text-slate-500 uppercase tracking-wider font-bold bg-slate-50/70">
                        <th class="py-3.5 px-4">Transaction ID</th>
                        <th class="py-3.5 px-4">Company</th>
                        <th class="py-3.5 px-4">Amount</th>
                        <th class="py-3.5 px-4">Gateway</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Date</th>
                        <th class="py-3.5 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($payments as $p)
                        <tr class="hover:bg-indigo-50/30 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-indigo-600">{{ $p->transaction_id }}</td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">{{ $p->company->name ?? 'N/A' }}</td>
                            <td class="py-3.5 px-4 font-black text-slate-900 font-mono">${{ number_format($p->amount, 2) }}</td>
                            <td class="py-3.5 px-4 capitalize text-slate-600 font-semibold">{{ $p->payment_method }}</td>
                            <td class="py-3.5 px-4">
                                @if($p->status === 'paid' || $p->status === 'succeeded')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase">Paid</span>
                                @elseif($p->status === 'pending')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200 uppercase">Pending</span>
                                @elseif($p->status === 'failed')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200 uppercase">Failed</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200 uppercase">{{ $p->status }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 font-mono">{{ $p->created_at->format('M d, Y H:i') }}</td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('admin.payments.show', $p->id) }}" class="px-2.5 py-1 rounded-xl glass-card hover:bg-indigo-50 text-indigo-600 hover:text-indigo-800 transition font-bold">
                                    Details &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 italic">No payment records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200/70">
            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection