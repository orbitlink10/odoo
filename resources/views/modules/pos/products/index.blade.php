<x-app-layout>
    <x-slot name="header"><div class="flex justify-between items-center"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2><a href="{{ route('pos.products.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Add Product</a></div></x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg overflow-hidden"><table class="min-w-full text-sm"><thead class="bg-gray-50"><tr><th class="p-3 text-left">SKU</th><th class="p-3 text-left">Name</th><th class="p-3 text-left">Price</th><th class="p-3 text-left">Stock</th><th class="p-3 text-left">Action</th></tr></thead><tbody>@forelse($products as $product)<tr class="border-t"><td class="p-3">{{ $product->sku }}</td><td class="p-3">{{ $product->name }}</td><td class="p-3">{{ number_format($product->price,2) }}</td><td class="p-3">{{ $product->inventory?->quantity ?? 0 }}</td><td class="p-3"><a class="text-blue-600" href="{{ route('pos.products.show', $product) }}">View</a></td></tr>@empty<tr><td class="p-3" colspan="5">No products.</td></tr>@endforelse</tbody></table></div>
        <div class="mt-4">{{ $products->links() }}</div>
    </div>
</x-app-layout>
