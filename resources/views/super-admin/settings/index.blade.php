@extends('layouts.super-admin')

@section('title', 'Platform Settings & Configuration')

@section('content')
<div class="space-y-6">
    <div class="glass-panel rounded-3xl p-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Platform Settings</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Configure global application identity, billing defaults, and system security.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf

        @foreach($settings as $group => $groupSettings)
            <div class="glass-panel rounded-3xl p-6 space-y-4 shadow-xl">
                <h3 class="text-base font-bold text-slate-900 capitalize border-b border-slate-200/70 pb-3 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-600 shadow-[0_0_8px_#6366f1]"></span>
                    <span>{{ $group }} Configuration</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($groupSettings as $setting)
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1 font-mono">
                                {{ strtoupper(str_replace('_', ' ', $setting->key)) }}
                            </label>
                            <input type="text" name="{{ $setting->key }}" value="{{ $setting->value }}" 
                                   class="w-full glass-input rounded-2xl px-4 py-2.5 text-xs text-slate-900 placeholder-slate-400 focus:outline-none">
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2.5 rounded-2xl font-bold text-xs bg-indigo-600 hover:bg-indigo-700 text-white shadow-lg shadow-indigo-600/30 transition">
                Save Platform Settings
            </button>
        </div>
    </form>
</div>
@endsection