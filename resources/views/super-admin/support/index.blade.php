@extends('layouts.super-admin')

@section('title', 'Customer Support Tickets')

@section('content')
<div class="space-y-6">
    <div class="glass-panel rounded-3xl p-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Support Tickets</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Tenant inquiries, technical issues, and priority incident reports.</p>
        </div>
        <div class="text-xs text-slate-500">Total: <strong class="text-slate-900">{{ $tickets->total() }}</strong></div>
    </div>

    <div class="glass-panel rounded-3xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200/80 text-slate-500 uppercase tracking-wider font-bold bg-slate-50/70">
                        <th class="py-3.5 px-4">Ticket</th>
                        <th class="py-3.5 px-4">Subject & Message</th>
                        <th class="py-3.5 px-4">Company</th>
                        <th class="py-3.5 px-4">Priority</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right">Last Updated</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($tickets as $t)
                        <tr class="hover:bg-indigo-50/30 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-indigo-600">{{ $t->ticket_number }}</td>
                            <td class="py-3.5 px-4 max-w-xs">
                                <div class="font-bold text-slate-900 truncate">{{ $t->subject }}</div>
                                <div class="text-[11px] text-slate-500 truncate">{{ $t->message }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-800">{{ $t->company->name ?? 'N/A' }}</td>
                            <td class="py-3.5 px-4">
                                @if($t->priority === 'urgent')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200 uppercase">Urgent</span>
                                @elseif($t->priority === 'high')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200 uppercase">High</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200 uppercase">{{ $t->priority }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                @if($t->status === 'open')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase">Open</span>
                                @elseif($t->status === 'in_progress')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-cyan-50 text-cyan-700 border border-cyan-200 uppercase">In Progress</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200 uppercase">{{ $t->status }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right text-slate-500 font-mono">{{ $t->updated_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 italic">No support tickets found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200/70">
            {{ $tickets->links() }}
        </div>
    </div>
</div>
@endsection