@extends('layouts.super-admin')

@section('title', 'Platform Users Directory')

@section('content')
<div class="space-y-6">
    <div class="glass-panel rounded-3xl p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Platform Users</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Super administrators, company owners, and tenant team members.</p>
        </div>
        <div class="text-xs text-slate-500">Total Users: <strong class="text-slate-900">{{ $users->total() }}</strong></div>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..." 
               class="flex-1 w-full glass-input rounded-2xl px-4 py-2.5 text-xs text-slate-900 placeholder-slate-400 focus:outline-none">
        <select name="role" onchange="this.form.submit()" class="glass-input rounded-2xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none">
            <option value="">All Roles</option>
            <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
            <option value="company_admin" {{ request('role') === 'company_admin' ? 'selected' : '' }}>Company Admin</option>
            <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Tenant Member</option>
        </select>
        <button type="submit" class="px-5 py-2.5 rounded-2xl text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white transition shadow-lg shadow-indigo-600/30">Filter</button>
    </form>

    <!-- Table -->
    <div class="glass-panel rounded-3xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-200/80 text-slate-500 uppercase tracking-wider font-bold bg-slate-50/70">
                        <th class="py-3.5 px-4">User</th>
                        <th class="py-3.5 px-4">Role</th>
                        <th class="py-3.5 px-4">Company</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Joined Date</th>
                        <th class="py-3.5 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-indigo-50/30 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-900 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-200 flex items-center justify-center text-xs font-bold text-indigo-700">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                                <div>
                                    <div class="text-slate-900 font-bold">{{ $user->name }}</div>
                                    <div class="text-[11px] text-slate-500 font-mono">{{ $user->email }}</div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($user->role === 'super_admin')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">Super Admin</span>
                                @elseif($user->role === 'company_admin')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-cyan-50 text-cyan-700 border border-cyan-200">Company Owner</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">Member</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-700 font-medium">
                                {{ $user->company->name ?? 'Platform Global' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    {{ ucfirst($user->status ?? 'active') }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 font-mono text-[11px]">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="px-2.5 py-1 rounded-xl glass-card hover:bg-indigo-50 text-indigo-600 hover:text-indigo-800 transition font-bold">
                                    Profile &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 italic">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200/70">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection