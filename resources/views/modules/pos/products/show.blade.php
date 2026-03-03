<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Product Details</h2></x-slot>
    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8"><div class="bg-white p-6 shadow sm:rounded-lg"><p>SKU: {{ $product->sku }}</p><p>Name: {{ $product->name }}</p><p>Price: {{ number_format($product->price,2) }}</p><p>Tax: {{ $product->tax_rate }}%</p><p>Stock: {{ $product->inventory?->quantity ?? 0 }}</p><div class="mt-4"><a class="text-amber-600" href="{{ route('pos.products.edit', $product) }}">Edit</a></div></div></div>
</x-app-layout>
