@extends('layouts.super-admin')

@section('title', 'User Profile: ' . $user->name)

@section('content')
<div class="space-y-6">
    <div class="glass-panel rounded-3xl p-6 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}" class="p-2.5 rounded-2xl glass-card text-slate-600 hover:text-slate-900 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-900 flex items-center gap-3">
                    <span>{{ $user->name }}</span>
                    <span class="text-xs uppercase px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200 font-bold">{{ str_replace('_', ' ', $user->role) }}</span>
                </h1>
                <p class="text-xs text-slate-500 mt-0.5 font-mono">{{ $user->email }} &bull; User ID: #{{ $user->id }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="glass-panel rounded-3xl p-6 space-y-4">
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-200/70 pb-2">User Information</h3>
            <div class="text-xs space-y-3 text-slate-600">
                <div class="flex justify-between"><span class="text-slate-500">Company:</span> <span class="text-slate-900 font-bold">{{ $user->company->name ?? 'Platform Global' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Phone:</span> <span class="text-slate-900">{{ $user->phone ?? 'N/A' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Account Status:</span> <span class="text-emerald-700 font-bold uppercase">{{ $user->status }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Email Verified:</span> <span class="text-slate-700">{{ $user->email_verified_at ? 'Verified' : 'Unverified' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Registered:</span> <span class="text-slate-900 font-mono">{{ $user->created_at->format('M d, Y H:i') }}</span></div>
            </div>
        </div>

        <div class="glass-panel rounded-3xl p-6 space-y-4">
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-200/70 pb-2">Associated Tenant Subscription</h3>
            @if($user->company && $user->company->activeSubscription)
                <div class="text-xs space-y-3 text-slate-600">
                    <div class="flex justify-between"><span class="text-slate-500">Company Name:</span> <a href="{{ route('admin.companies.show', $user->company->id) }}" class="text-indigo-600 hover:underline font-bold">{{ $user->company->name }}</a></div>
                    <div class="flex justify-between"><span class="text-slate-500">Plan:</span> <span class="text-slate-900 font-bold">{{ $user->company->activeSubscription->plan->name ?? 'Custom' }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Price:</span> <span class="text-emerald-700 font-mono font-bold">${{ number_format($user->company->activeSubscription->plan->price ?? 0, 2) }}/mo</span></div>
                </div>
            @else
                <p class="text-xs text-slate-400 py-4">User is not attached to an active subscription tier.</p>
            @endif
        </div>
    </div>
</div>
@endsection