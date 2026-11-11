@extends('layouts.super-admin')

@section('title', 'Subscription Pricing Plans')

@section('content')
<div class="space-y-6">
    <div class="glass-panel rounded-3xl p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Subscription Plans</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Configure pricing tiers, features, billing cycles, and quotas.</p>
        </div>
        <button class="px-4 py-2.5 rounded-2xl text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-600/30 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <span>Create New Plan</span>
        </button>
    </div>

    <!-- Pricing Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($plans as $plan)
            <div class="glass-panel rounded-3xl p-6 relative flex flex-col justify-between {{ $plan->is_featured ? 'border-indigo-400 shadow-[0_10px_35px_rgba(99,102,241,0.15)] ring-2 ring-indigo-500/20' : '' }}">
                @if($plan->is_featured)
                    <div class="absolute -top-3 right-6 px-3 py-1 bg-gradient-to-r from-indigo-600 to-cyan-500 text-white text-[10px] font-black uppercase tracking-wider rounded-full shadow-md">
                        Featured Tier
                    </div>
                @endif

                <div>
                    <h3 class="text-lg font-black text-slate-900">{{ $plan->name }}</h3>
                    <p class="text-xs text-slate-500 mt-1 min-h-[32px]">{{ $plan->description }}</p>

                    <div class="my-6">
                        <span class="text-3xl font-black text-slate-900 font-mono">${{ number_format($plan->price, 0) }}</span>
                        <span class="text-xs text-slate-400 uppercase font-bold">/ {{ $plan->billing_cycle }}</span>
                    </div>

                    <div class="space-y-2.5 pt-4 border-t border-slate-200/70 text-xs text-slate-600">
                        @if(is_array($plan->features))
                            @foreach($plan->features as $feat)
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span class="font-medium">{{ $feat }}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="mt-8 pt-4 border-t border-slate-200/70 flex items-center justify-between">
                    <span class="text-xs text-slate-500 font-bold">{{ $plan->subscriptions_count }} active tenants</span>
                    <button class="px-3 py-1.5 rounded-xl glass-card text-xs font-bold text-slate-700 hover:bg-slate-100 transition">Edit Plan</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection