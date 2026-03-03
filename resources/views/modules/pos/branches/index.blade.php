<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-bold text-xl text-slate-800">POS Branches</h2>
            <span class="text-sm text-slate-500">Multi-branch operations overview</span>
        </div>
    </x-slot>

    <div class="space-y-6">
        <section class="rounded-3xl bg-gradient-to-r from-sky-500 to-teal-700 text-white p-6 md:p-8 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-6">
                <div>
                    <span class="inline-flex items-center rounded-full bg-white/15 px-4 py-2 text-sm font-semibold">Branch operations</span>
                    <h3 class="mt-4 text-4xl md:text-5xl font-extrabold">Manage all POS branches</h3>
                    <p class="mt-3 text-xl text-white/90">View branch status, setup progress, and branch-level operations.</p>
                </div>
                <button class="rounded-2xl bg-white text-slate-900 px-5 py-3 font-bold text-lg">Add Branch</button>
            </div>
        </section>

        <section class="rounded-3xl border border-slate-200 bg-white p-5">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left p-3 font-semibold">Branch</th>
                        <th class="text-left p-3 font-semibold">Location</th>
                        <th class="text-left p-3 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($branches as $branch)
                        <tr class="border-t border-slate-100">
                            <td class="p-3 font-semibold text-slate-900">{{ $branch['name'] }}</td>
                            <td class="p-3">{{ $branch['location'] }}</td>
                            <td class="p-3">
                                <span class="inline-flex rounded-2xl px-3 py-1 text-xs font-semibold {{ $branch['status'] === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ ucfirst($branch['status']) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>
</x-app-layout>
