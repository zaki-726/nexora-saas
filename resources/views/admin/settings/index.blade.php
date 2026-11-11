@extends('layouts.admin')

@section('title', 'Platform Settings & Configuration')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between pb-2 border-b border-slate-800">
        <div>
            <h1 class="text-2xl font-black text-white tracking-tight">Platform Settings</h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Configure global application identity, billing defaults, and system security.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf

        @foreach($settings as $group => $groupSettings)
            <div class="bg-slate-900/80 border border-slate-800 rounded-3xl p-6 shadow-xl space-y-4">
                <h3 class="text-base font-bold text-white capitalize border-b border-slate-800 pb-3 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    <span>{{ $group }} Configuration</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($groupSettings as $setting)
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 mb-1 font-mono">
                                {{ strtoupper(str_replace('_', ' ', $setting->key)) }}
                            </label>
                            <input type="text" name="{{ $setting->key }}" value="{{ $setting->value }}" 
                                   class="w-full bg-slate-800/80 border border-slate-700/80 rounded-xl px-4 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500">
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2.5 rounded-xl font-bold text-xs bg-indigo-600 hover:bg-indigo-500 text-white shadow-lg shadow-indigo-600/30 transition">
                Save Platform Settings
            </button>
        </div>
    </form>
</div>
@endsection
