<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Property Reports</h2></x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white p-6 shadow sm:rounded-lg"><p class="text-sm text-gray-500">Occupancy</p><p class="text-3xl font-bold">{{ $occupancyRate }}% ({{ $occupiedUnits }}/{{ $totalUnits }})</p></div>
        <div class="bg-white p-6 shadow sm:rounded-lg"><h3 class="font-semibold mb-2">Arrears</h3><ul class="space-y-2">@forelse($arrears as $invoice)<li>{{ $invoice->invoice_no }} - {{ $invoice->lease?->rentalTenant?->name }} - {{ number_format($invoice->balance,2) }}</li>@empty<li>No arrears.</li>@endforelse</ul></div>
    </div>
</x-app-layout>
