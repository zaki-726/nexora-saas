<!-- 7. Recent Registered Companies Table Component (Gracious Light Glass) -->
<div class="glass-panel rounded-3xl p-5 sm:p-6 shadow-2xl space-y-4"
     x-data="{
         suspendModalOpen: false,
         selectedCompanyId: null,
         selectedCompanyName: '',
         suspensionReason: '',
         openSuspendModal(id, name) {
             this.selectedCompanyId = id;
             this.selectedCompanyName = name;
             this.suspensionReason = '';
             this.suspendModalOpen = true;
         }
     }">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-200/70">
        <div>
            <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>Recent Registered Companies</span>
                <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">Latest 10 Tenants</span>
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">Recently onboarded multi-tenant instances, subscription tiers, and access states.</p>
        </div>
        <a href="{{ route('admin.companies.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 transition flex items-center gap-1 self-start sm:self-auto">
            <span>View All Companies</span>
            <span>&rarr;</span>
        </a>
    </div>

    <!-- Table Container -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="text-slate-500 uppercase tracking-wider border-b border-slate-200/80 font-bold bg-slate-50/70">
                    <th class="py-3 px-3">Company</th>
                    <th class="py-3 px-3">Owner</th>
                    <th class="py-3 px-3">Email</th>
                    <th class="py-3 px-3">Current Plan</th>
                    <th class="py-3 px-3">Status</th>
                    <th class="py-3 px-3">Joined Date</th>
                    <th class="py-3 px-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($recentCompanies as $company)
                    <tr class="hover:bg-indigo-50/30 transition">
                        <!-- Logo & Company Name -->
                        <td class="py-3 px-3 font-bold text-slate-900 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-black shadow-sm border border-white/40 shrink-0">
                                {{ substr($company->name, 0, 2) }}
                            </div>
                            <div class="min-w-0">
                                <span class="truncate block font-bold text-slate-900">{{ $company->name }}</span>
                                <span class="text-[11px] text-slate-500 font-mono">{{ $company->domain ?? ($company->slug . '.nexora.app') }}</span>
                            </div>
                        </td>

                        <!-- Owner -->
                        <td class="py-3 px-3 text-slate-700 font-medium">
                            {{ $company->owner->name ?? ($company->users->first()?->name ?? 'Admin') }}
                        </td>

                        <!-- Email -->
                        <td class="py-3 px-3 text-slate-500">
                            {{ $company->email ?? ($company->owner->email ?? 'N/A') }}
                        </td>

                        <!-- Plan -->
                        <td class="py-3 px-3">
                            <span class="px-2 py-0.5 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-700 font-bold text-[11px]">
                                {{ $company->activeSubscription->plan->name ?? 'Custom Plan' }}
                            </span>
                        </td>

                        <!-- Status -->
                        <td class="py-3 px-3">
                            @if($company->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Active
                                </span>
                            @elseif($company->status === 'suspended')
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200"
                                      title="{{ $company->suspension_reason ?? 'Suspended by admin' }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Suspended
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Pending
                                </span>
                            @endif
                        </td>

                        <!-- Joined Date -->
                        <td class="py-3 px-3 text-slate-500 font-mono text-[11px]">
                            {{ $company->created_at->format('M d, Y') }}
                        </td>

                        <!-- Action Buttons -->
                        <td class="py-3 px-3 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <!-- View Details -->
                                <a href="{{ route('admin.companies.show', $company->id) }}" 
                                   class="px-2.5 py-1 rounded-xl glass-card hover:bg-indigo-50 text-indigo-600 hover:text-indigo-800 transition font-bold"
                                   title="View full tenant details, users, and subscriptions">
                                    View
                                </a>

                                <!-- Suspend / Reactivate Trigger -->
                                @if($company->status === 'suspended')
                                    <form method="POST" action="{{ route('admin.companies.activate', $company->id) }}" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="px-2.5 py-1 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 transition font-bold"
                                                title="Reactivate this tenant">
                                            Reactivate
                                        </button>
                                    </form>
                                @else
                                    <button type="button" 
                                            @click="openSuspendModal({{ $company->id }}, '{{ addslashes($company->name) }}')"
                                            class="px-2.5 py-1 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 transition font-bold"
                                            title="Suspend tenant workspace">
                                        Suspend
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-500 italic">No registered tenants found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Suspend Confirmation Glass Modal -->
    <div x-cloak
         x-show="suspendModalOpen"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-md"
         x-transition:enter="ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="glass-panel w-full max-w-lg rounded-3xl p-6 shadow-2xl border border-rose-200/80 space-y-4"
             @click.outside="suspendModalOpen = false">
            
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 border border-rose-200 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Suspend Company Access</h3>
                    <p class="text-xs text-slate-500">Tenant: <strong class="text-slate-900" x-text="selectedCompanyName"></strong></p>
                </div>
            </div>

            <p class="text-xs text-slate-600 leading-relaxed bg-rose-50/70 p-3.5 rounded-2xl border border-rose-200/60">
                Suspending this company will immediately restrict all associated tenant users from accessing protected workspace modules. Company database records will remain intact and will not be deleted.
            </p>

            <form :action="'{{ url('admin/companies') }}/' + selectedCompanyId + '/suspend'" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Reason for Suspension <span class="text-rose-600">*</span></label>
                    <textarea name="reason" x-model="suspensionReason" required rows="3" placeholder="e.g. Terms of service violation, unverified billing dispute, requested by compliance..."
                              class="w-full glass-input rounded-2xl p-3 text-xs text-slate-900 placeholder-slate-400 focus:outline-none"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" @click="suspendModalOpen = false" class="px-4 py-2 rounded-xl glass-card text-xs font-bold text-slate-600 hover:text-slate-900 transition">
                        Cancel
                    </button>
                    <button type="submit" 
                            :disabled="suspensionReason.trim().length < 5"
                            class="px-4 py-2 rounded-xl text-xs font-bold bg-rose-600 hover:bg-rose-700 text-white shadow-lg shadow-rose-600/25 transition disabled:opacity-50">
                        Confirm Suspension
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>