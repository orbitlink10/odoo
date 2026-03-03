<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-bold text-xl text-slate-800">POS Pages</h2>
            <span class="text-sm text-slate-500">Knowledge pages for retail teams</span>
        </div>
    </x-slot>

    <div class="space-y-6">
        <section class="rounded-3xl bg-gradient-to-r from-sky-500 to-teal-700 text-white p-6 md:p-8 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-6">
                <div>
                    <span class="inline-flex items-center rounded-full bg-white/15 px-4 py-2 text-sm font-semibold">Knowledge base</span>
                    <h3 class="mt-4 text-4xl md:text-5xl font-extrabold">POS information pages</h3>
                    <p class="mt-3 text-xl text-white/90">Maintain cashier guides, policies, and customer-facing references.</p>
                </div>
                <button class="rounded-2xl bg-white text-slate-900 px-5 py-3 font-bold text-lg">Create Page</button>
            </div>
        </section>

        <section class="rounded-3xl border border-slate-200 bg-white p-5">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left p-3 font-semibold">Page</th>
                        <th class="text-left p-3 font-semibold">Last Updated</th>
                        <th class="text-left p-3 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                        <tr class="border-t border-slate-100">
                            <td class="p-3 font-semibold text-slate-900">{{ $page['name'] }}</td>
                            <td class="p-3">{{ $page['updated']->format('d M Y') }}</td>
                            <td class="p-3">
                                <span class="inline-flex rounded-2xl px-3 py-1 text-xs font-semibold {{ $page['status'] === 'published' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                    {{ ucfirst($page['status']) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>
</x-app-layout>
