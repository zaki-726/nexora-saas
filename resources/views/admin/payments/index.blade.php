@extends('layouts.admin')

@section('title', 'Platform Payments & Transactions')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between pb-2 border-b border-slate-800">
        <div>
            <h1 class="text-2xl font-black text-white tracking-tight">Payments & Transactions</h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Audit log of all settled, pending, and refunded payment transactions.</p>
        </div>
        <div class="text-xs text-slate-400">Total: <strong class="text-white">{{ $payments->total() }}</strong></div>
    </div>

    <div class="bg-slate-900/80 border border-slate-800 rounded-3xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-950/40 text-slate-400 uppercase tracking-wider border-b border-slate-800/80 font-semibold">
                        <th class="py-3.5 px-4">Transaction ID</th>
                        <th class="py-3.5 px-4">Company</th>
                        <th class="py-3.5 px-4">Amount</th>
                        <th class="py-3.5 px-4">Gateway</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right">Processed At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/40 text-slate-300">
                    @forelse($payments as $p)
                        <tr class="hover:bg-slate-850/40 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-indigo-400">{{ $p->transaction_id }}</td>
                            <td class="py-3.5 px-4 font-bold text-white">{{ $p->company->name ?? 'N/A' }}</td>
                            <td class="py-3.5 px-4 font-black text-white">${{ number_format($p->amount, 2) }}</td>
                            <td class="py-3.5 px-4 capitalize text-slate-400">{{ $p->payment_method }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 uppercase">
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right text-slate-400">{{ $p->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">No payment records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-800">
            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection
