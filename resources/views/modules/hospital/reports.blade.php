<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Hospital Reports</h2></x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white shadow sm:rounded-lg p-6"><p class="text-sm text-gray-500">Daily Revenue</p><p class="text-3xl font-bold">{{ number_format($dailyRevenue, 2) }}</p></div>
        <div class="bg-white shadow sm:rounded-lg p-6"><h3 class="font-semibold mb-2">Unpaid Bills</h3><ul class="space-y-2">@forelse($unpaidBills as $bill)<li>{{ $bill->bill_no }} - {{ $bill->patient?->full_name }} - {{ number_format($bill->balance,2) }}</li>@empty<li>No unpaid bills.</li>@endforelse</ul></div>
    </div>
</x-app-layout>
