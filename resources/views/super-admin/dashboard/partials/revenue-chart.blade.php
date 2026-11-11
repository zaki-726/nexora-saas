<!-- 5. Revenue Analytics Line Chart Component (Gracious Light Glass) -->
<div class="glass-panel rounded-3xl p-5 sm:p-6 shadow-2xl flex flex-col justify-between"
     x-data="{
         period: '6m',
         loading: false,
         totalRevenue: 38900,
         previousRevenue: 32900,
         growth: 18.2,
         customFrom: '',
         customTo: '',
         chart: null,
         init() {
             this.initChart();
             this.fetchAnalytics('6m');
         },
         fetchAnalytics(p) {
             this.period = p;
             this.loading = true;
             let url = '{{ route('admin.revenue.analytics') }}?period=' + p;
             if (p === 'custom' && this.customFrom && this.customTo) {
                 url += '&from=' + this.customFrom + '&to=' + this.customTo;
             }
             fetch(url, { headers: { 'Accept': 'application/json' } })
                 .then(res => res.json())
                 .then(data => {
                     this.totalRevenue = data.totalRevenue;
                     this.previousRevenue = data.previousRevenue;
                     this.growth = data.growth;
                     this.updateChart(data.labels, data.currentData, data.previousData);
                     this.loading = false;
                 })
                 .catch(() => { this.loading = false; });
         },
         initChart() {
             const ctx = document.getElementById('revenueAnalyticsCanvas').getContext('2d');
             const gradient = ctx.createLinearGradient(0, 0, 0, 300);
             gradient.addColorStop(0, 'rgba(99, 102, 241, 0.22)');
             gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

             this.chart = new Chart(ctx, {
                 type: 'line',
                 data: {
                     labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                     datasets: [
                         {
                             label: 'Current Period Revenue',
                             data: [4500, 5200, 6100, 5800, 7400, 8900],
                             borderColor: '#4f46e5',
                             backgroundColor: gradient,
                             borderWidth: 2.5,
                             fill: true,
                             tension: 0.4,
                             pointBackgroundColor: '#4f46e5',
                             pointBorderColor: '#ffffff',
                             pointBorderWidth: 2,
                             pointRadius: 4,
                             pointHoverRadius: 6,
                         },
                         {
                             label: 'Previous Period Comparison',
                             data: [3800, 4400, 5100, 4900, 6300, 7500],
                             borderColor: 'rgba(148, 163, 184, 0.8)',
                             borderDash: [5, 5],
                             borderWidth: 2,
                             fill: false,
                             tension: 0.4,
                             pointRadius: 0,
                             pointHoverRadius: 4,
                         }
                     ]
                 },
                 options: {
                     responsive: true,
                     maintainAspectRatio: false,
                     interaction: { mode: 'index', intersect: false },
                     plugins: {
                         legend: {
                             display: true,
                             position: 'top',
                             align: 'end',
                             labels: {
                                 boxWidth: 12,
                                 boxHeight: 6,
                                 color: '#64748b',
                                 font: { size: 11, family: 'Plus Jakarta Sans', weight: '600' },
                                 usePointStyle: true,
                             }
                         },
                         tooltip: {
                             backgroundColor: 'rgba(255, 255, 255, 0.96)',
                             titleColor: '#0f172a',
                             bodyColor: '#334155',
                             borderColor: '#e2e8f0',
                             borderWidth: 1,
                             padding: 12,
                             cornerRadius: 12,
                             boxShadow: '0 10px 25px -3px rgba(0, 0, 0, 0.1)',
                             callbacks: {
                                 label: (ctx) => ' ' + ctx.dataset.label + ': $' + Number(ctx.parsed.y).toLocaleString()
                             }
                         }
                     },
                     scales: {
                         x: {
                             grid: { color: 'rgba(226, 232, 240, 0.7)', drawBorder: false },
                             ticks: { color: '#64748b', font: { size: 11, family: 'Plus Jakarta Sans', weight: '500' } }
                         },
                         y: {
                             grid: { color: 'rgba(226, 232, 240, 0.7)', drawBorder: false },
                             ticks: {
                                 color: '#64748b',
                                 font: { size: 11, family: 'Plus Jakarta Sans', weight: '500' },
                                 callback: (val) => '$' + val.toLocaleString()
                             }
                         }
                     }
                 }
             });
         },
         updateChart(labels, currentData, previousData) {
             if (!this.chart) return;
             this.chart.data.labels = labels;
             this.chart.data.datasets[0].data = currentData;
             this.chart.data.datasets[1].data = previousData;
             this.chart.update();
         }
     }">
    
    <!-- Header with Period Selectors & Comparison Summary -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-200/70">
        <div>
            <div class="flex items-center gap-2.5">
                <h3 class="text-base font-black text-slate-900 tracking-tight">Platform Revenue Growth</h3>
                <span class="w-2 h-2 rounded-full bg-indigo-600 shadow-[0_0_8px_#6366f1]"></span>
            </div>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-2xl font-black text-slate-900 tracking-tight" x-text="'$' + Number(totalRevenue).toLocaleString()">$38,900</span>
                <span class="text-xs font-bold px-2 py-0.5 rounded-full border"
                      :class="growth >= 0 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200'">
                    <span x-text="(growth >= 0 ? '+' : '') + growth + '% vs prev period'">+18.2% vs prev period</span>
                </span>
            </div>
        </div>

        <!-- Filter Buttons (7d, 30d, 6m, 12m) -->
        <div class="flex flex-wrap items-center gap-1.5 p-1 rounded-2xl glass-card">
            <button type="button" @click="fetchAnalytics('7d')"
                    :class="period === '7d' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                    class="px-2.5 py-1 text-xs font-bold rounded-xl transition">
                7 Days
            </button>
            <button type="button" @click="fetchAnalytics('30d')"
                    :class="period === '30d' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                    class="px-2.5 py-1 text-xs font-bold rounded-xl transition">
                30 Days
            </button>
            <button type="button" @click="fetchAnalytics('6m')"
                    :class="period === '6m' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                    class="px-2.5 py-1 text-xs font-bold rounded-xl transition">
                6 Months
            </button>
            <button type="button" @click="fetchAnalytics('12m')"
                    :class="period === '12m' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                    class="px-2.5 py-1 text-xs font-bold rounded-xl transition">
                12 Months
            </button>
        </div>
    </div>

    <!-- Chart Canvas Container with Glass Depth -->
    <div class="h-72 w-full mt-4 relative">
        <canvas id="revenueAnalyticsCanvas"></canvas>
    </div>
</div>