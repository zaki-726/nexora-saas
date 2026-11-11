@extends('layouts.super-admin')

@section('title', 'Transaction Details: ' . $payment->transaction_id)

@section('content')
<div class="space-y-6">
    <div class="glass-panel rounded-3xl p-6 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.payments.index') }}" class="p-2.5 rounded-2xl glass-card text-slate-600 hover:text-slate-900 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-900 flex items-center gap-3">
                    <span class="font-mono text-indigo-600">{{ $payment->transaction_id }}</span>
                    <span class="text-xs uppercase px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold">{{ $payment->status }}</span>
                </h1>
                <p class="text-xs text-slate-500 mt-1">Tenant: <strong class="text-slate-900">{{ $payment->company->name ?? 'N/A' }}</strong> &bull; Settled on {{ $payment->paid_at?->format('M d, Y H:i:s') ?? $payment->created_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="glass-panel rounded-3xl p-6 space-y-4">
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-200/70 pb-2">Payment Breakdown</h3>
            <div class="text-xs space-y-3 text-slate-600">
                <div class="flex justify-between"><span class="text-slate-500">Gross Amount:</span> <span class="font-black text-slate-900 font-mono text-sm">${{ number_format($payment->amount, 2) }} {{ $payment->currency }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Gateway Provider:</span> <span class="font-bold text-slate-900 capitalize">{{ $payment->payment_method }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Payment Status:</span> <span class="text-emerald-700 font-bold uppercase">{{ $payment->status }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Refund Status:</span> <span class="text-slate-700 font-medium">Clean / Settled</span></div>
            </div>
        </div>

        <div class="glass-panel rounded-3xl p-6 space-y-4">
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-200/70 pb-2">Associated Company & Invoice</h3>
            <div class="text-xs space-y-3 text-slate-600">
                <div class="flex justify-between"><span class="text-slate-500">Company:</span> <a href="{{ route('admin.companies.show', $payment->company_id) }}" class="text-indigo-600 hover:underline font-bold">{{ $payment->company->name ?? 'N/A' }}</a></div>
                <div class="flex justify-between"><span class="text-slate-500">Plan:</span> <span class="text-slate-900 font-bold">{{ $payment->subscription->plan->name ?? 'Custom Plan' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Invoice Reference:</span> <span class="text-slate-900 font-mono">{{ $payment->invoice->invoice_number ?? 'Auto-generated' }}</span></div>
            </div>
        </div>
    </div>
</div>
@endsection