@extends('layouts.admin')

@section('title', 'Platform Announcements')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between pb-2 border-b border-slate-800">
        <div>
            <h1 class="text-2xl font-black text-white tracking-tight">Platform Announcements</h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Broadcast system maintenance, new product features, or pricing updates to all tenants.</p>
        </div>
        <button class="px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white shadow-lg shadow-indigo-600/30 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <span>New Announcement</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($announcements as $a)
            <div class="bg-slate-900/80 border border-slate-800 rounded-3xl p-6 shadow-xl space-y-3">
                <div class="flex items-center justify-between">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                        {{ $a->badge_type === 'warning' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : ($a->badge_type === 'success' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-indigo-500/20 text-indigo-300 border border-indigo-500/30') }}">
                        {{ $a->badge_type }}
                    </span>
                    <span class="text-xs text-slate-400">{{ $a->created_at->diffForHumans() }}</span>
                </div>
                <h3 class="text-base font-bold text-white">{{ $a->title }}</h3>
                <p class="text-xs text-slate-300 leading-relaxed">{{ $a->content }}</p>
                <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between text-xs text-slate-400">
                    <span>Target Audience: <strong class="text-slate-200 capitalize">{{ $a->target }}</strong></span>
                    <span class="text-emerald-400 font-semibold">Published</span>
                </div>
            </div>
        @empty
            <p class="text-xs text-slate-400">No announcements published yet.</p>
        @endforelse
    </div>
</div>
@endsection
