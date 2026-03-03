<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">POS Daily Report</h2></x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white p-6 shadow sm:rounded-lg"><p class="text-sm text-gray-500">Gross Sales (Today)</p><p class="text-3xl font-bold">{{ number_format($gross,2) }}</p></div>
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <h3 class="font-semibold mb-2">Transactions</h3>
            <ul class="space-y-2">
                @forelse($todaySales as $sale)
                    <li><a class="text-blue-600" href="{{ route('pos.receipts.show', $sale) }}">{{ $sale->sale_no }}</a> - {{ number_format($sale->total,2) }}</li>
                @empty
                    <li>No sales today.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>
