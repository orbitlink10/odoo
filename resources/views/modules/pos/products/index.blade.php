<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-extrabold text-2xl md:text-3xl text-slate-900 leading-none tracking-tight">Products</h2>
            <a href="{{ route('pos.products.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-[#1779a6] px-5 py-3 text-white text-lg font-bold shadow-sm transition hover:bg-[#116b92]">
                <span class="text-2xl leading-none">+</span>
                Add Product
            </a>
        </div>
    </x-slot>

    <div class="max-w-[1380px] mx-auto space-y-6">
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <section class="rounded-[24px] border border-[#c8d2de] bg-[#f8fafc] p-5 md:p-7 shadow-sm">
            <h3 class="text-3xl leading-none font-extrabold text-slate-900">Catalog</h3>
            <p class="mt-3 text-[2rem] leading-tight font-semibold text-[#4d617b]">Manage items available for sale.</p>

            <div class="mt-6 flex flex-wrap gap-3">
                <form method="GET" action="{{ route('pos.products.index') }}" class="flex-1 min-w-[240px]">
                    <label for="product_search" class="sr-only">Search products</label>
                    <input
                        id="product_search"
                        name="q"
                        value="{{ $search ?? '' }}"
                        placeholder="Search products..."
                        class="w-full rounded-2xl border border-[#d4dde8] bg-white px-4 py-3 text-lg text-slate-700 placeholder:text-slate-400 focus:border-sky-500 focus:ring-sky-500"
                    >
                </form>

                <a href="{{ route('pos.products.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-[#1779a6] px-5 py-3 text-white text-lg font-bold shadow-sm transition hover:bg-[#116b92]">
                    <span class="text-2xl leading-none">+</span>
                    Add Product
                </a>
                <button type="button" class="inline-flex items-center gap-2 rounded-2xl bg-[#209ad8] px-5 py-3 text-white text-lg font-bold shadow-sm opacity-90 cursor-not-allowed" title="Add Category page not available yet">
                    <span aria-hidden="true">[+]</span>
                    Add Category
                </button>
                <button type="button" class="inline-flex items-center gap-2 rounded-2xl bg-[#22c55e] px-5 py-3 text-white text-lg font-bold shadow-sm opacity-90 cursor-not-allowed" title="Supplier management not available yet">
                    <span aria-hidden="true">[+]</span>
                    Add Supplier
                </button>
                <button type="button" class="inline-flex items-center gap-2 rounded-2xl bg-[#f59e0b] px-5 py-3 text-white text-lg font-bold shadow-sm opacity-90 cursor-not-allowed" title="Stock adjustment flow not available yet">
                    <span aria-hidden="true">[+]</span>
                    Adjust Stock
                </button>
            </div>

            <div class="mt-5 overflow-x-auto rounded-2xl border border-[#d3dbe6] bg-white">
                <table class="min-w-full text-sm md:text-[1.05rem]">
                    <thead class="bg-[#f0f4fa] text-[#111d2f]">
                        <tr>
                            <th class="text-left p-3 md:p-4 font-extrabold">Name</th>
                            <th class="text-left p-3 md:p-4 font-extrabold">SKU</th>
                            <th class="text-left p-3 md:p-4 font-extrabold">Serial</th>
                            <th class="text-left p-3 md:p-4 font-extrabold">Cost</th>
                            <th class="text-left p-3 md:p-4 font-extrabold">Price</th>
                            <th class="text-left p-3 md:p-4 font-extrabold">Stock</th>
                            <th class="text-left p-3 md:p-4 font-extrabold">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e3e9f1]">
                        @forelse ($products as $product)
                            @php
                                $stockQty = (float) ($product->inventory?->quantity ?? 0);
                                $serialNo = 'PRD-'.str_pad((string) $product->id, 8, '0', STR_PAD_LEFT);
                            @endphp
                            <tr class="bg-white hover:bg-slate-50/70">
                                <td class="p-3 md:p-4 text-slate-900 font-semibold">{{ $product->name }}</td>
                                <td class="p-3 md:p-4 text-slate-900 break-words">{{ $product->sku }}</td>
                                <td class="p-3 md:p-4 text-slate-900">{{ $serialNo }}</td>
                                <td class="p-3 md:p-4 text-slate-900">
                                    <span class="block">KES</span>
                                    <span class="font-semibold text-slate-600">N/A</span>
                                </td>
                                <td class="p-3 md:p-4 text-slate-900">
                                    <span class="block">KES</span>
                                    <span>{{ number_format((float) $product->price, 2) }}</span>
                                </td>
                                <td class="p-3 md:p-4 text-slate-900">{{ rtrim(rtrim(number_format($stockQty, 2), '0'), '.') }}</td>
                                <td class="p-3 md:p-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('pos.products.edit', $product) }}" class="inline-flex items-center rounded-xl border border-[#b7d4fb] bg-[#edf5ff] px-4 py-2 text-[#2563eb] font-bold hover:bg-[#dcecff]">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('pos.products.destroy', $product) }}" onsubmit="return confirm('Delete this product? This action can be reversed only from backups.');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="inline-flex items-center rounded-xl border border-[#f4c3c3] bg-[#fff1f1] px-4 py-2 text-[#c81e1e] font-bold hover:bg-[#ffe3e3]" type="submit">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="p-5 text-center text-slate-500" colspan="7">No products found. Add your first product to build your catalog.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                {{ $products->links() }}
            </div>
        </section>
    </div>
</x-app-layout>
