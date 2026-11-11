@extends('layouts.admin')

@section('title', 'Billing Invoices')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between pb-2 border-b border-slate-800">
        <div>
            <h1 class="text-2xl font-black text-white tracking-tight">Invoices</h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Platform billing receipts, tax breakdown, and invoicing records.</p>
        </div>
        <div class="text-xs text-slate-400">Total: <strong class="text-white">{{ $invoices->total() }}</strong></div>
    </div>

    <div class="bg-slate-900/80 border border-slate-800 rounded-3xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-950/40 text-slate-400 uppercase tracking-wider border-b border-slate-800/80 font-semibold">
                        <th class="py-3.5 px-4">Invoice #</th>
                        <th class="py-3.5 px-4">Company</th>
                        <th class="py-3.5 px-4">Subtotal</th>
                        <th class="py-3.5 px-4">Tax</th>
                        <th class="py-3.5 px-4">Total</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right">Due Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/40 text-slate-300">
                    @forelse($invoices as $inv)
                        <tr class="hover:bg-slate-850/40 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-indigo-400">{{ $inv->invoice_number }}</td>
                            <td class="py-3.5 px-4 font-bold text-white">{{ $inv->company->name ?? 'N/A' }}</td>
                            <td class="py-3.5 px-4 text-slate-400">${{ number_format($inv->subtotal, 2) }}</td>
                            <td class="py-3.5 px-4 text-slate-400">${{ number_format($inv->tax, 2) }}</td>
                            <td class="py-3.5 px-4 font-black text-white">${{ number_format($inv->total, 2) }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 uppercase">
                                    {{ $inv->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right text-slate-400">{{ $inv->due_date?->format('M d, Y') ?? 'Immediate' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">No invoices found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-800">
            {{ $invoices->links() }}
        </div>
    </div>
</div>
@endsection
