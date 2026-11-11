@extends('layouts.super-admin')

@section('title', 'Platform Announcements')

@section('content')
<div class="space-y-6">
    <div class="glass-panel rounded-3xl p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Platform Announcements</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Broadcast system maintenance, new product features, or pricing updates to all tenants.</p>
        </div>
        <button class="px-4 py-2.5 rounded-2xl text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-600/30 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <span>New Announcement</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($announcements as $a)
            <div class="glass-panel rounded-3xl p-6 space-y-3 shadow-xl">
                <div class="flex items-center justify-between">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                        {{ $a->badge_type === 'warning' ? 'bg-amber-50 text-amber-700 border border-amber-200' : ($a->badge_type === 'success' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-indigo-50 text-indigo-700 border border-indigo-200') }}">
                        {{ $a->badge_type }}
                    </span>
                    <span class="text-xs text-slate-400 font-mono">{{ $a->created_at->diffForHumans() }}</span>
                </div>
                <h3 class="text-base font-bold text-slate-900">{{ $a->title }}</h3>
                <p class="text-xs text-slate-600 leading-relaxed">{{ $a->content }}</p>
                <div class="pt-3 border-t border-slate-200/70 flex items-center justify-between text-xs text-slate-500">
                    <span>Target: <strong class="text-slate-800 capitalize">{{ $a->target }}</strong></span>
                    <span class="text-emerald-700 font-bold">Published</span>
                </div>
            </div>
        @empty
            <p class="text-xs text-slate-400 py-6 text-center italic">No announcements published yet.</p>
        @endforelse
    </div>
</div>
@endsection