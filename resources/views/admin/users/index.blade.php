@extends('layouts.admin')

@section('title', 'Platform Users Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-800">
        <div>
            <h1 class="text-2xl font-black text-white tracking-tight">Platform Users</h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Directory of super administrators, company owners, and tenant team members.</p>
        </div>
        <div class="text-xs text-slate-400">
            Total Users: <strong class="text-white">{{ $users->total() }}</strong>
        </div>
    </div>

    <!-- Filter -->
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by user name or email..." 
               class="flex-1 w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500">
        <select name="role" onchange="this.form.submit()" class="bg-slate-900 border border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-300 focus:outline-none focus:border-indigo-500">
            <option value="">All Roles</option>
            <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
            <option value="company_admin" {{ request('role') === 'company_admin' ? 'selected' : '' }}>Company Admin</option>
            <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Member</option>
        </select>
        <button type="submit" class="px-4 py-2 rounded-xl text-xs font-semibold bg-indigo-600 hover:bg-indigo-500 text-white transition">Filter</button>
    </form>

    <!-- Table -->
    <div class="bg-slate-900/80 border border-slate-800 rounded-3xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-950/40 text-slate-400 uppercase tracking-wider border-b border-slate-800/80 font-semibold">
                        <th class="py-3.5 px-4">User</th>
                        <th class="py-3.5 px-4">Role</th>
                        <th class="py-3.5 px-4">Company</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/40 text-slate-300">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-850/40 transition">
                            <td class="py-3.5 px-4 font-bold text-white flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-xs font-bold text-indigo-400">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                                <div>
                                    <div class="text-white font-bold">{{ $user->name }}</div>
                                    <div class="text-[11px] text-slate-400 font-normal">{{ $user->email }}</div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($user->role === 'super_admin')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-500/20 text-indigo-300 border border-indigo-500/40">Super Admin</span>
                                @elseif($user->role === 'company_admin')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-cyan-500/20 text-cyan-300 border border-cyan-500/40">Company Admin</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-800 text-slate-400 border border-slate-700">Tenant Member</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-300 font-medium">
                                {{ $user->company->name ?? 'Platform Global' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    {{ ucfirst($user->status ?? 'active') }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-400">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">No users found matching query.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-800">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
