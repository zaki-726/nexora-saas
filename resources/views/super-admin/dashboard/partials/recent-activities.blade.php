<!-- 9. Recent Activity Logs Timeline Component (Gracious Light Glass) -->
<div class="glass-panel rounded-3xl p-5 sm:p-6 shadow-2xl space-y-4">
    <div class="flex items-center justify-between pb-3 border-b border-slate-200/70">
        <div>
            <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>Platform Activity Timeline</span>
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">Immutable audit trail of authentication, tenant events, and billing actions.</p>
        </div>
        <a href="{{ route('admin.activities.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 transition flex items-center gap-1">
            <span>Audit Logs</span>
            <span>&rarr;</span>
        </a>
    </div>

    <!-- Timeline Feed -->
    <div class="space-y-3.5">
        @forelse($recentActivities as $act)
            <div class="flex items-start gap-3 p-2.5 rounded-2xl hover:bg-indigo-50/40 transition group">
                <!-- Action Icon -->
                <div class="mt-0.5 w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>

                <div class="text-xs flex-1 min-w-0">
                    <div class="flex items-baseline justify-between gap-2">
                        <p class="text-slate-900 font-bold truncate">{{ $act->description }}</p>
                        <span class="text-[10px] text-slate-400 font-mono shrink-0">{{ $act->created_at->diffForHumans() }}</span>
                    </div>

                    <div class="flex items-center gap-2 mt-1 text-[11px] text-slate-500">
                        <span class="font-bold text-indigo-600">{{ $act->user->name ?? 'System Automated' }}</span>
                        <span>&bull;</span>
                        <span class="font-mono text-slate-400 text-[10px]">{{ $act->action }}</span>
                        @if($act->ip_address)
                            <span>&bull;</span>
                            <span class="font-mono text-slate-400 text-[10px]">{{ $act->ip_address }}</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="text-xs text-slate-400 py-6 text-center italic">No audit activity logged.</p>
        @endforelse
    </div>
</div>