<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-bold text-xl text-slate-800">School Dashboard</h2>
            <div class="text-sm text-slate-500">{{ now()->format('D, d M Y') }}</div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <section class="rounded-3xl bg-gradient-to-r from-sky-500 to-teal-700 text-white p-6 md:p-8 shadow-sm">
            <div class="flex flex-wrap items-start justify-between gap-6">
                <div class="max-w-3xl">
                    <span class="inline-flex items-center rounded-full bg-white/15 px-4 py-2 text-sm font-semibold">Live school snapshot</span>
                    <h3 class="mt-4 text-5xl md:text-6xl font-extrabold">Welcome back</h3>
                    <p class="mt-3 text-2xl text-white/90">Track admissions, class performance, fee collection, and outstanding balances at a glance.</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('school.students.create') }}" class="rounded-2xl bg-white text-slate-900 px-5 py-3 font-bold text-lg">Register Student</a>
                        <a href="{{ route('school.classes.index') }}" class="rounded-2xl bg-white/90 text-slate-900 px-5 py-3 font-bold text-lg">Classes</a>
                        <a href="{{ route('school.reports') }}" class="rounded-2xl bg-white/90 text-slate-900 px-5 py-3 font-bold text-lg">Today's Summary</a>
                    </div>
                </div>

                <div class="text-right min-w-[190px]">
                    <span class="inline-flex items-center rounded-2xl bg-white/80 text-slate-800 px-4 py-2 font-semibold">Today</span>
                    <p class="mt-4 text-6xl font-extrabold">KES {{ number_format($todayCollections, 2) }}</p>
                    <p class="text-2xl text-white/90">Fees collected</p>
                </div>
            </div>
        </section>

        <section class="grid md:grid-cols-2 xl:grid-cols-4 gap-4">
            <article class="rounded-3xl border border-slate-200 bg-white p-5">
                <p class="text-2xl text-slate-600">{{ $currentMonthLabel }} Collections</p>
                <p class="mt-2 text-5xl font-extrabold text-slate-900">KES {{ number_format($monthCollections, 2) }}</p>
                <span class="mt-3 inline-flex rounded-2xl bg-sky-100 text-sky-800 px-4 py-2 text-sm font-semibold">Month to date</span>
            </article>

            <article class="rounded-3xl border border-slate-200 bg-white p-5">
                <p class="text-2xl text-slate-600">This Week</p>
                <p class="mt-2 text-5xl font-extrabold text-slate-900">KES {{ number_format($weekCollections, 2) }}</p>
                <span class="mt-3 inline-flex rounded-2xl bg-emerald-100 text-emerald-800 px-4 py-2 text-sm font-semibold">Week to date</span>
            </article>

            <article class="rounded-3xl border border-slate-200 bg-white p-5">
                <p class="text-2xl text-slate-600">Today's Collections</p>
                <p class="mt-2 text-5xl font-extrabold text-slate-900">KES {{ number_format($todayCollections, 2) }}</p>
                <span class="mt-3 inline-flex rounded-2xl bg-cyan-100 text-cyan-800 px-4 py-2 text-sm font-semibold">Daily run-rate</span>
            </article>

            <article class="rounded-3xl border border-slate-200 bg-white p-5">
                <p class="text-2xl text-slate-600">Outstanding Fees</p>
                <p class="mt-2 text-5xl font-extrabold text-slate-900">KES {{ number_format($invoiceOutstanding, 2) }}</p>
                <span class="mt-3 inline-flex rounded-2xl bg-amber-100 text-amber-800 px-4 py-2 text-sm font-semibold">Needs action</span>
            </article>
        </section>

        <section class="grid md:grid-cols-2 xl:grid-cols-4 gap-4">
            <article class="rounded-3xl border border-slate-200 bg-white p-5">
                <p class="text-2xl text-slate-600">New Admissions</p>
                <p class="mt-2 text-5xl font-extrabold text-slate-900">{{ number_format($todayAdmissions) }}</p>
                <span class="mt-3 inline-flex rounded-2xl bg-indigo-100 text-indigo-800 px-4 py-2 text-sm font-semibold">Today</span>
            </article>

            <article class="rounded-3xl border border-slate-200 bg-white p-5">
                <p class="text-2xl text-slate-600">Overdue Invoices</p>
                <p class="mt-2 text-5xl font-extrabold text-slate-900">{{ number_format($overdueInvoicesCount) }}</p>
                <span class="mt-3 inline-flex rounded-2xl bg-rose-100 text-rose-800 px-4 py-2 text-sm font-semibold">Needs attention</span>
            </article>
        </section>

        <section class="rounded-3xl border border-slate-200 bg-white p-5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h3 class="text-4xl font-extrabold text-slate-900">{{ now()->year }} Monthly Billing & Collections</h3>
                    <p class="text-slate-500">Month-by-month totals and trend chart.</p>
                </div>
                <span class="inline-flex rounded-2xl bg-sky-100 text-sky-800 px-4 py-2 text-sm font-semibold">Year to date view</span>
            </div>

            <div class="mt-5 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="text-left p-3 font-semibold">Month</th>
                            <th class="text-left p-3 font-semibold">Billed</th>
                            <th class="text-left p-3 font-semibold">Collected</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($monthlySummary as $row)
                            <tr class="border-t border-slate-100">
                                <td class="p-3 font-semibold text-slate-800">{{ $row['month'] }}</td>
                                <td class="p-3">KES {{ number_format($row['billed'], 2) }}</td>
                                <td class="p-3">KES {{ number_format($row['collected'], 2) }}</td>
                            </tr>
                        @empty
                            <tr><td class="p-3 text-slate-500" colspan="3">No monthly data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="grid xl:grid-cols-2 gap-4">
            <article class="rounded-3xl border border-slate-200 bg-white p-5">
                <h3 class="text-2xl font-extrabold text-slate-900">Recent Students</h3>
                <ul class="mt-3 divide-y divide-slate-100">
                    @forelse($recentStudents as $student)
                        <li class="py-2 flex justify-between text-sm">
                            <span class="font-medium text-slate-700">{{ $student->full_name }}</span>
                            <span class="font-semibold text-slate-600">{{ $student->admission_no }}</span>
                        </li>
                    @empty
                        <li class="py-2 text-slate-500 text-sm">No students yet.</li>
                    @endforelse
                </ul>
            </article>

            <article class="rounded-3xl border border-slate-200 bg-white p-5">
                <h3 class="text-2xl font-extrabold text-slate-900">Outstanding Invoices</h3>
                <ul class="mt-3 divide-y divide-slate-100">
                    @forelse($dueInvoices as $invoice)
                        <li class="py-2 flex items-center justify-between gap-2 text-sm">
                            <div>
                                <p class="font-semibold text-slate-800">{{ $invoice->invoice_no }}</p>
                                <p class="text-slate-500">{{ $invoice->student?->full_name ?? 'Unknown student' }} - {{ $invoice->due_date?->format('d M Y') }}</p>
                            </div>
                            <a class="font-semibold text-sky-700" href="{{ route('school.fee-invoices.show', $invoice) }}">KES {{ number_format($invoice->balance, 2) }}</a>
                        </li>
                    @empty
                        <li class="py-2 text-slate-500 text-sm">No outstanding invoices.</li>
                    @endforelse
                </ul>
            </article>
        </section>
    </div>
</x-app-layout>
