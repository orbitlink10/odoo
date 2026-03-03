<x-app-layout>
    @php
        $kpiCardClass = 'rounded-[24px] border border-[#c8d2de] bg-[#f8fafc] p-5';
        $kpiTitleClass = 'text-[2rem] leading-tight text-slate-600';
        $kpiValueClass = 'mt-3 text-4xl md:text-[2.75rem] leading-none font-extrabold text-slate-900 tracking-tight';
    @endphp

    <div class="space-y-6 max-w-[1360px] mx-auto">
        <section class="rounded-[28px] bg-gradient-to-r from-sky-500 to-teal-700 text-white p-7 md:p-8 shadow-sm" style="background: linear-gradient(90deg, #149DE4 0%, #108D8D 100%);">
            <div class="flex flex-wrap items-start justify-between gap-6">
                <div class="max-w-3xl">
                    <span class="inline-flex items-center rounded-full bg-white/15 px-5 py-2.5 text-lg font-semibold">Live store snapshot</span>
                    <h3 class="mt-4 text-5xl md:text-6xl leading-[1.02] font-extrabold">Welcome back</h3>
                    <p class="mt-3 text-2xl text-white/90">Track sales performance, stock health, and today's profit at a glance.</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('pos.screen') }}" class="rounded-2xl bg-white text-slate-900 px-5 py-3 font-bold text-[1.4rem] leading-none">Open POS</a>
                        <a href="{{ route('pos.products.index') }}" class="rounded-2xl bg-white/90 text-slate-900 px-5 py-3 font-bold text-[1.4rem] leading-none">Stock</a>
                        <a href="{{ route('pos.reports') }}" class="rounded-2xl bg-white/90 text-slate-900 px-5 py-3 font-bold text-[1.4rem] leading-none">Today's Summary</a>
                    </div>
                </div>

                <div class="text-right min-w-[220px] md:pt-2">
                    <span class="inline-flex items-center rounded-2xl bg-white/80 text-slate-800 px-4 py-2 text-lg font-semibold">Today</span>
                    <p class="mt-4 text-5xl md:text-6xl leading-none font-extrabold">KES {{ number_format($todaySales, 2) }}</p>
                    <p class="text-2xl text-white/90">Sales closed</p>
                </div>
            </div>
        </section>

        <section class="grid md:grid-cols-2 xl:grid-cols-5 gap-4">
            <article class="{{ $kpiCardClass }}">
                <p class="{{ $kpiTitleClass }}">{{ $currentMonthLabel }} Sales</p>
                <p class="mt-3 text-[2rem] leading-none font-extrabold text-slate-900">KES</p>
                <p class="mt-2 text-4xl md:text-[2.5rem] leading-none font-extrabold text-slate-900 tracking-tight">{{ number_format($monthToDateSales, 2) }}</p>
                <span class="mt-4 inline-flex rounded-2xl bg-sky-100 text-sky-800 px-4 py-2 text-lg font-semibold">Month to date</span>
            </article>

            <article class="{{ $kpiCardClass }}">
                <p class="{{ $kpiTitleClass }}">This Week</p>
                <p class="mt-3 text-[2rem] leading-none font-extrabold text-slate-900">KES</p>
                <p class="mt-2 text-4xl md:text-[2.5rem] leading-none font-extrabold text-slate-900 tracking-tight">{{ number_format($weekToDateSales, 2) }}</p>
                <span class="mt-4 inline-flex rounded-2xl bg-emerald-100 text-emerald-800 px-4 py-2 text-lg font-semibold">Week to date</span>
            </article>

            <article class="{{ $kpiCardClass }}">
                <p class="{{ $kpiTitleClass }}">Today's Sales</p>
                <p class="{{ $kpiValueClass }}">KES {{ number_format($todaySales, 2) }}</p>
                <span class="mt-4 inline-flex rounded-2xl bg-cyan-100 text-cyan-800 px-4 py-2 text-lg font-semibold">Daily run-rate</span>
            </article>

            <article class="{{ $kpiCardClass }}">
                <p class="{{ $kpiTitleClass }}">Today's Profit</p>
                <p class="{{ $kpiValueClass }}">KES {{ number_format($todayProfit, 2) }}</p>
                <span class="mt-4 inline-flex rounded-2xl bg-amber-100 text-amber-800 px-4 py-2 text-lg font-semibold">After cost</span>
            </article>

            <article class="{{ $kpiCardClass }}">
                <p class="{{ $kpiTitleClass }}">Low Stock</p>
                <p class="{{ $kpiValueClass }}">{{ $lowStockCount }}</p>
                <span class="mt-4 inline-flex rounded-2xl bg-rose-100 text-rose-800 px-4 py-2 text-lg font-semibold">Needs attention</span>
            </article>
        </section>

        <section class="grid md:grid-cols-2 xl:grid-cols-5 gap-4">
            <article class="{{ $kpiCardClass }} xl:col-span-1">
                <p class="{{ $kpiTitleClass }}">Out of Stock</p>
                <p class="{{ $kpiValueClass }}">{{ $outOfStockCount }}</p>
                <span class="mt-4 inline-flex rounded-2xl bg-yellow-100 text-yellow-800 px-4 py-2 text-lg font-semibold">Unavailable</span>
            </article>
        </section>

        <section class="rounded-[24px] border border-[#c8d2de] bg-[#f8fafc] p-6">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h3 class="text-4xl md:text-[2.8rem] leading-none font-extrabold text-slate-900">{{ now()->year }} Monthly Sales & Profit</h3>
                    <p class="mt-2 text-2xl text-slate-500">Month-by-month totals and trend snapshot.</p>
                </div>
                <span class="inline-flex rounded-2xl bg-sky-100 text-sky-800 px-4 py-2 text-lg font-semibold">Year to date view</span>
            </div>

            <div class="mt-5 overflow-x-auto">
                <table class="min-w-full text-lg">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="text-left p-3 font-semibold">Month</th>
                            <th class="text-left p-3 font-semibold">Sales</th>
                            <th class="text-left p-3 font-semibold">Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($monthlySummary as $row)
                            <tr class="border-t border-slate-100">
                                <td class="p-3 font-semibold text-slate-800">{{ $row['month'] }}</td>
                                <td class="p-3">KES {{ number_format($row['sales'], 2) }}</td>
                                <td class="p-3">KES {{ number_format($row['profit'], 2) }}</td>
                            </tr>
                        @empty
                            <tr><td class="p-3 text-slate-500" colspan="3">No monthly data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="grid xl:grid-cols-2 gap-4">
            <article class="rounded-[24px] border border-[#c8d2de] bg-[#f8fafc] p-5">
                <h3 class="text-3xl font-extrabold leading-none text-slate-900">Low Stock Products</h3>
                <ul class="mt-3 divide-y divide-slate-100">
                    @forelse($lowStockProducts as $stock)
                        <li class="py-2 flex justify-between text-lg">
                            <span class="font-medium text-slate-700">{{ $stock->product?->name ?? 'Unknown product' }}</span>
                            <span class="font-semibold {{ $stock->quantity <= 0 ? 'text-rose-600' : 'text-amber-600' }}">{{ number_format($stock->quantity, 2) }}</span>
                        </li>
                    @empty
                        <li class="py-2 text-slate-500 text-lg">No low-stock alerts.</li>
                    @endforelse
                </ul>
            </article>

            <article class="rounded-[24px] border border-[#c8d2de] bg-[#f8fafc] p-5">
                <h3 class="text-3xl font-extrabold leading-none text-slate-900">Recent Sales</h3>
                <ul class="mt-3 divide-y divide-slate-100">
                    @forelse($recentSales as $sale)
                        <li class="py-2 flex items-center justify-between gap-2 text-lg">
                            <div>
                                <p class="font-semibold text-slate-800">{{ $sale->sale_no }}</p>
                                <p class="text-slate-500">{{ $sale->customer?->name ?? 'Walk-in' }} • {{ $sale->sold_at?->format('d M H:i') }}</p>
                            </div>
                            <a class="font-semibold text-sky-700" href="{{ route('pos.receipts.show', $sale) }}">KES {{ number_format($sale->total, 2) }}</a>
                        </li>
                    @empty
                        <li class="py-2 text-slate-500 text-lg">No sales recorded yet.</li>
                    @endforelse
                </ul>
            </article>
        </section>
    </div>
</x-app-layout>
