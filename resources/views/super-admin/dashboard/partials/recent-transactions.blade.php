<!-- 8. Recent Transactions Table Component (Gracious Light Glass) -->
<div class="glass-panel rounded-3xl p-5 sm:p-6 shadow-2xl space-y-4"
     x-data="{
         detailModalOpen: false,
         txn: null,
         openTxn(data) {
             this.txn = data;
             this.detailModalOpen = true;
         }
     }">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-200/70">
        <div>
            <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>Recent Platform Transactions</span>
                <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-cyan-50 text-cyan-700 border border-cyan-200">Latest 10</span>
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">Audited payment settlements, gateway logs, and billing invoices.</p>
        </div>
        <a href="{{ route('admin.payments.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 transition flex items-center gap-1 self-start sm:self-auto">
            <span>View All Transactions</span>
            <span>&rarr;</span>
        </a>
    </div>

    <!-- Table Container -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="text-slate-500 uppercase tracking-wider border-b border-slate-200/80 font-bold bg-slate-50/70">
                    <th class="py-3 px-3">Transaction ID</th>
                    <th class="py-3 px-3">Company (Tenant)</th>
                    <th class="py-3 px-3">Amount</th>
                    <th class="py-3 px-3">Gateway</th>
                    <th class="py-3 px-3">Date</th>
                    <th class="py-3 px-3">Status</th>
                    <th class="py-3 px-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($recentTransactions as $payment)
                    <tr class="hover:bg-indigo-50/30 transition">
                        <!-- Transaction ID -->
                        <td class="py-3 px-3 font-mono font-bold text-indigo-600">
                            {{ $payment->transaction_id }}
                        </td>

                        <!-- Company -->
                        <td class="py-3 px-3 font-bold text-slate-900">
                            {{ $payment->company->name ?? 'Deleted Tenant' }}
                        </td>

                        <!-- Amount -->
                        <td class="py-3 px-3 font-mono font-black text-slate-900">
                            ${{ number_format($payment->amount, 2) }}
                            <span class="text-[10px] text-slate-400 font-normal">USD</span>
                        </td>

                        <!-- Gateway -->
                        <td class="py-3 px-3 capitalize text-slate-600 font-medium">
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-lg bg-slate-100 border border-slate-200">
                                @if($payment->payment_method === 'stripe')
                                    <span class="text-indigo-600 font-bold">Stripe</span>
                                @elseif($payment->payment_method === 'paypal')
                                    <span class="text-blue-600 font-bold">PayPal</span>
                                @else
                                    <span class="font-bold">{{ ucfirst($payment->payment_method) }}</span>
                                @endif
                            </span>
                        </td>

                        <!-- Date -->
                        <td class="py-3 px-3 text-slate-500 font-mono text-[11px]">
                            {{ $payment->created_at->format('M d, Y H:i') }}
                        </td>

                        <!-- Status Badge -->
                        <td class="py-3 px-3">
                            @if($payment->status === 'paid' || $payment->status === 'succeeded')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Paid
                                </span>
                            @elseif($payment->status === 'pending')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Pending
                                </span>
                            @elseif($payment->status === 'failed')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Failed
                                </span>
                            @elseif($payment->status === 'refunded')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                    Refunded
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] bg-slate-100 text-slate-700 font-bold">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            @endif
                        </td>

                        <!-- Action -->
                        <td class="py-3 px-3 text-right">
                            <button type="button" 
                                    @click="openTxn({
                                        id: '{{ $payment->id }}',
                                        reference: '{{ $payment->transaction_id }}',
                                        company: '{{ addslashes($payment->company->name ?? 'N/A') }}',
                                        amount: '{{ number_format($payment->amount, 2) }}',
                                        currency: '{{ $payment->currency }}',
                                        gateway: '{{ ucfirst($payment->payment_method) }}',
                                        status: '{{ ucfirst($payment->status) }}',
                                        paidAt: '{{ $payment->paid_at ? $payment->paid_at->format('M d, Y H:i:s') : 'Pending settlement' }}',
                                        plan: '{{ addslashes($payment->subscription->plan->name ?? 'Custom Plan') }}'
                                    })"
                                    class="px-2.5 py-1 rounded-xl glass-card hover:bg-indigo-50 text-indigo-600 hover:text-indigo-800 transition font-bold">
                                View details
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-500 italic">No transactions recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Transaction Details Glass Modal -->
    <div x-cloak
         x-show="detailModalOpen"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-md"
         x-transition:enter="ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="glass-panel w-full max-w-md rounded-3xl p-6 shadow-2xl border border-slate-200/80 space-y-4"
             @click.outside="detailModalOpen = false"
             x-show="txn">
            
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Transaction Breakdown</h3>
                    <p class="text-[11px] text-slate-500 font-mono" x-text="txn?.reference"></p>
                </div>
                <button @click="detailModalOpen = false" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Details List -->
            <div class="space-y-2.5 text-xs">
                <div class="flex justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500">Tenant Company:</span>
                    <span class="font-bold text-slate-900" x-text="txn?.company"></span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500">Subscription Tier:</span>
                    <span class="font-bold text-indigo-600" x-text="txn?.plan"></span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500">Total Charged:</span>
                    <span class="font-black text-slate-900 font-mono" x-text="'$' + txn?.amount + ' ' + txn?.currency"></span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500">Payment Gateway:</span>
                    <span class="font-bold text-slate-800" x-text="txn?.gateway"></span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500">Settlement Timestamp:</span>
                    <span class="text-slate-700 font-mono text-[11px]" x-text="txn?.paidAt"></span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500">Status:</span>
                    <span class="font-bold text-emerald-700 uppercase" x-text="txn?.status"></span>
                </div>
                <div class="flex justify-between py-1.5">
                    <span class="text-slate-500">Refund Status:</span>
                    <span class="text-slate-700 font-medium">Not Requested / No Chargeback</span>
                </div>
            </div>

            <!-- Security Notice Banner -->
            <div class="p-3.5 rounded-2xl bg-indigo-50/80 border border-indigo-100 text-[11px] text-slate-700 leading-snug">
                <strong class="text-indigo-700 block mb-0.5">Automated Gateway Verification:</strong>
                Status changes are restricted to authenticated webhooks from Stripe/PayPal. Manual status overrides without gateway confirmation are prohibited.
            </div>

            <div class="pt-2 text-right">
                <button type="button" @click="detailModalOpen = false" class="px-4 py-2 rounded-xl glass-card text-xs font-bold text-slate-700 hover:bg-slate-100 transition">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>