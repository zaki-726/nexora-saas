@extends('layouts.admin')

@section('title', 'Platform Activity Audit Logs')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between pb-2 border-b border-slate-800">
        <div>
            <h1 class="text-2xl font-black text-white tracking-tight">Activity Logs</h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Immutable security audit trails for logins, plan changes, and tenant events.</p>
        </div>
        <div class="text-xs text-slate-400">Total: <strong class="text-white">{{ $activities->total() }}</strong></div>
    </div>

    <div class="bg-slate-900/80 border border-slate-800 rounded-3xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-950/40 text-slate-400 uppercase tracking-wider border-b border-slate-800/80 font-semibold">
                        <th class="py-3.5 px-4">Event Action</th>
                        <th class="py-3.5 px-4">Description</th>
                        <th class="py-3.5 px-4">User</th>
                        <th class="py-3.5 px-4">IP Address</th>
                        <th class="py-3.5 px-4 text-right">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/40 text-slate-300">
                    @forelse($activities as $act)
                        <tr class="hover:bg-slate-850/40 transition">
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-lg bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 font-mono font-semibold text-[11px]">
                                    {{ $act->action }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-white max-w-sm">
                                {{ $act->description }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-400">
                                {{ $act->user->name ?? 'System Automated' }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-400">
                                {{ $act->ip_address ?? '127.0.0.1' }}
                            </td>
                            <td class="py-3.5 px-4 text-right text-slate-400">
                                {{ $act->created_at->format('M d, Y H:i:s') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">No activity logs recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-800">
            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection
