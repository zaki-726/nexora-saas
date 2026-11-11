@extends('layouts.super-admin')

@section('title', 'Platform Invoices')

@section('content')
<div class="space-y-6">
    <div class="glass-panel rounded-3xl p-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Billing Invoices</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Platform billing receipts, tax breakdown, and invoicing records.</p>
        </div>
        <div class="text-xs text-slate-500">Total: <strong class="text-slate-900">{{ $invoices->total() }}</strong></div>
    </div>

    <div class="glass-panel rounded-3xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200/80 text-slate-500 uppercase tracking-wider font-bold bg-slate-50/70">
                        <th class="py-3.5 px-4">Invoice #</th>
                        <th class="py-3.5 px-4">Company</th>
                        <th class="py-3.5 px-4">Subtotal</th>
                        <th class="py-3.5 px-4">Tax</th>
                        <th class="py-3.5 px-4">Total</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right">Due Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($invoices as $inv)
                        <tr class="hover:bg-indigo-50/30 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-indigo-600">{{ $inv->invoice_number }}</td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">{{ $inv->company->name ?? 'N/A' }}</td>
                            <td class="py-3.5 px-4 font-mono text-slate-600">${{ number_format($inv->subtotal, 2) }}</td>
                            <td class="py-3.5 px-4 font-mono text-slate-500">${{ number_format($inv->tax, 2) }}</td>
                            <td class="py-3.5 px-4 font-mono font-black text-slate-900">${{ number_format($inv->total, 2) }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase">
                                    {{ $inv->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right text-slate-500 font-mono">{{ $inv->due_date?->format('M d, Y') ?? 'Immediate' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 italic">No invoices found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200/70">
            {{ $invoices->links() }}
        </div>
    </div>
</div>
@endsection