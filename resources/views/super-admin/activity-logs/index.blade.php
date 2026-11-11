@extends('layouts.super-admin')

@section('title', 'Platform Activity Logs')

@section('content')
<div class="space-y-6">
    <div class="glass-panel rounded-3xl p-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Activity Logs</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Immutable security audit trails for logins, plan changes, and tenant events.</p>
        </div>
        <div class="text-xs text-slate-500">Total: <strong class="text-slate-900">{{ $activities->total() }}</strong></div>
    </div>

    <div class="glass-panel rounded-3xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200/80 text-slate-500 uppercase tracking-wider font-bold bg-slate-50/70">
                        <th class="py-3.5 px-4">Event Action</th>
                        <th class="py-3.5 px-4">Description</th>
                        <th class="py-3.5 px-4">User</th>
                        <th class="py-3.5 px-4">IP Address</th>
                        <th class="py-3.5 px-4 text-right">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($activities as $act)
                        <tr class="hover:bg-indigo-50/30 transition">
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-xl bg-indigo-50 text-indigo-700 border border-indigo-200 font-mono font-bold text-[11px]">
                                    {{ $act->action }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-900 max-w-sm">
                                {{ $act->description }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-medium">
                                {{ $act->user->name ?? 'System Automated' }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-500">
                                {{ $act->ip_address ?? '127.0.0.1' }}
                            </td>
                            <td class="py-3.5 px-4 text-right text-slate-500 font-mono">
                                {{ $act->created_at->format('M d, Y H:i:s') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 italic">No activity logs recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200/70">
            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection