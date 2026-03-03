<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Property Details</h2></x-slot>
    <div class="py-6 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="bg-white p-6 shadow sm:rounded-lg"><h3 class="font-semibold text-lg">{{ $property->name }}</h3><p>{{ $property->type }} | {{ $property->location }}</p></div>
        <div class="bg-white p-6 shadow sm:rounded-lg"><h4 class="font-semibold mb-2">Units</h4><ul class="space-y-1">@forelse($property->units as $unit)<li>{{ $unit->unit_no }} - {{ $unit->status }} - {{ number_format($unit->rent_amount,2) }}</li>@empty<li>No units yet.</li>@endforelse</ul></div>
    </div>
</x-app-layout>
