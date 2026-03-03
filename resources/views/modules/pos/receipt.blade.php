<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Receipt {{ $sale->receipt?->receipt_no }}</h2></x-slot>
    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <p>Sale #: {{ $sale->sale_no }}</p>
            <p>Date: {{ $sale->sold_at?->format('Y-m-d H:i') }}</p>
            <p>Customer: {{ $sale->customer?->name ?? 'Walk-in' }}</p>
        </div>
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <h3 class="font-semibold mb-2">Items</h3>
            <ul class="space-y-1">
                @foreach($sale->items as $item)
                    <li>{{ $item->product?->name }} - {{ $item->quantity }} x {{ number_format($item->unit_price,2) }} = {{ number_format($item->line_total,2) }}</li>
                @endforeach
            </ul>
            <div class="mt-4 pt-4 border-t">
                <p>Subtotal: {{ number_format($sale->subtotal,2) }}</p>
                <p>Discount: {{ number_format($sale->discount_total,2) }}</p>
                <p>Tax: {{ number_format($sale->tax_total,2) }}</p>
                <p class="font-semibold text-lg">Total: {{ number_format($sale->total,2) }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
