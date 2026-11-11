<!-- 6. Subscription Analytics Doughnut Chart Component (Gracious Light Glass) -->
<div class="glass-panel rounded-3xl p-5 sm:p-6 shadow-2xl flex flex-col justify-between"
     x-data="{
         total: 1250,
         monthlyGrowth: 15.4,
         breakdown: { active: 940, trial: 150, expired: 80, cancelled: 50, past_due: 30 },
         chart: null,
         init() {
             this.initDoughnut();
             this.fetchSubscriptionData();
         },
         fetchSubscriptionData() {
             fetch('{{ route('admin.subscription.analytics') }}', { headers: { 'Accept': 'application/json' } })
                 .then(res => res.json())
                 .then(data => {
                     this.total = data.total;
                     this.monthlyGrowth = data.monthlyGrowth;
                     this.breakdown = data.breakdown;
                     if (this.chart) {
                         this.chart.data.labels = data.labels;
                         this.chart.data.datasets[0].data = data.counts;
                         this.chart.update();
                     }
                 })
                 .catch(() => {});
         },
         initDoughnut() {
             const ctx = document.getElementById('subscriptionAnalyticsCanvas').getContext('2d');
             this.chart = new Chart(ctx, {
                 type: 'doughnut',
                 data: {
                     labels: ['Active', 'Trial', 'Expired', 'Cancelled', 'Past Due'],
                     datasets: [{
                         data: [940, 150, 80, 50, 30],
                         backgroundColor: [
                             '#6366f1', // Active (Indigo)
                             '#06b6d4', // Trial (Cyan)
                             '#94a3b8', // Expired (Slate)
                             '#f43f5e', // Cancelled (Rose)
                             '#f59e0b', // Past Due (Amber)
                         ],
                         borderColor: '#ffffff',
                         borderWidth: 3,
                         hoverOffset: 6
                     }]
                 },
                 options: {
                     responsive: true,
                     maintainAspectRatio: false,
                     plugins: {
                         legend: { display: false },
                         tooltip: {
                             backgroundColor: 'rgba(255, 255, 255, 0.96)',
                             titleColor: '#0f172a',
                             bodyColor: '#334155',
                             borderColor: '#e2e8f0',
                             borderWidth: 1,
                             padding: 10,
                             cornerRadius: 10,
                             boxShadow: '0 10px 25px -3px rgba(0, 0, 0, 0.1)'
                         }
                     },
                     cutout: '72%'
                 }
             });
         }
     }">
    
    <div>
        <div class="flex items-center justify-between pb-3 border-b border-slate-200/70">
            <div>
                <h3 class="text-base font-black text-slate-900 tracking-tight">Subscription Distribution</h3>
                <p class="text-xs text-slate-500 mt-0.5">Status breakdown & active tenant ratio</p>
            </div>
            <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200"
                  x-text="'+' + monthlyGrowth + '% MoM'">
                +15.4% MoM
            </span>
        </div>

        <!-- Doughnut Canvas with Center Counter -->
        <div class="h-48 relative flex items-center justify-center my-3">
            <canvas id="subscriptionAnalyticsCanvas"></canvas>
            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                <span class="text-2xl font-black text-slate-900 tracking-tight" x-text="Number(total).toLocaleString()">1,250</span>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Total Seats</span>
            </div>
        </div>
    </div>

    <!-- Status Legend Breakdown Badges -->
    <div class="space-y-2 pt-3 border-t border-slate-200/70 text-xs">
        <div class="flex items-center justify-between">
            <span class="flex items-center gap-2 text-slate-600 font-medium">
                <span class="w-2.5 h-2.5 rounded-full bg-[#6366f1] shadow-[0_0_8px_#6366f1]"></span>
                <span>Active</span>
            </span>
            <span class="font-bold text-slate-900 font-mono" x-text="breakdown.active">940</span>
        </div>
        <div class="flex items-center justify-between">
            <span class="flex items-center gap-2 text-slate-600 font-medium">
                <span class="w-2.5 h-2.5 rounded-full bg-[#06b6d4] shadow-[0_0_8px_#06b6d4]"></span>
                <span>Trialing</span>
            </span>
            <span class="font-bold text-slate-900 font-mono" x-text="breakdown.trial">150</span>
        </div>
        <div class="flex items-center justify-between">
            <span class="flex items-center gap-2 text-slate-600 font-medium">
                <span class="w-2.5 h-2.5 rounded-full bg-[#94a3b8]"></span>
                <span>Expired</span>
            </span>
            <span class="font-bold text-slate-500 font-mono" x-text="breakdown.expired">80</span>
        </div>
        <div class="flex items-center justify-between">
            <span class="flex items-center gap-2 text-slate-600 font-medium">
                <span class="w-2.5 h-2.5 rounded-full bg-[#f43f5e] shadow-[0_0_8px_#f43f5e]"></span>
                <span>Cancelled</span>
            </span>
            <span class="font-bold text-rose-600 font-mono" x-text="breakdown.cancelled">50</span>
        </div>
        <div class="flex items-center justify-between">
            <span class="flex items-center gap-2 text-slate-600 font-medium">
                <span class="w-2.5 h-2.5 rounded-full bg-[#f59e0b] shadow-[0_0_8px_#f59e0b]"></span>
                <span>Past Due</span>
            </span>
            <span class="font-bold text-amber-600 font-mono" x-text="breakdown.past_due">30</span>
        </div>
    </div>
</div>