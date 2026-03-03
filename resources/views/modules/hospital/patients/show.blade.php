<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Patient Details</h2></x-slot>
    <div class="py-6 max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold">{{ $patient->full_name }}</h3>
            <p>Patient No: {{ $patient->patient_no }}</p>
            <p>Phone: {{ $patient->phone }}</p>
            <p>Email: {{ $patient->email }}</p>
        </div>
        <div class="bg-white shadow sm:rounded-lg p-6">
            <h4 class="font-semibold mb-2">Recent Bills</h4>
            <ul class="space-y-2">@forelse($patient->bills as $bill)<li><a class="text-blue-600" href="{{ route('hospital.bills.show', $bill) }}">{{ $bill->bill_no }}</a> - Balance {{ number_format($bill->balance,2) }}</li>@empty<li>No bills.</li>@endforelse</ul>
        </div>
    </div>
</x-app-layout>
