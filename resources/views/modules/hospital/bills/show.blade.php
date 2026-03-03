<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Bill {{ $bill->bill_no }}</h2></x-slot>
    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="bg-white shadow sm:rounded-lg p-6"><p>Patient: {{ $bill->patient?->full_name }}</p><p>Total: {{ number_format($bill->total,2) }}</p><p>Paid: {{ number_format($bill->paid_amount,2) }}</p><p>Balance: {{ number_format($bill->balance,2) }}</p><p>Status: {{ $bill->status }}</p></div>
        <div class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="font-semibold mb-3">Items</h3>
            <ul class="space-y-2">@foreach($bill->items as $item)<li>{{ $item->description }} - {{ $item->quantity }} x {{ number_format($item->unit_price,2) }}</li>@endforeach</ul>
            <h3 class="font-semibold mt-6 mb-3">Record Payment</h3>
            <form method="POST" action="{{ route('hospital.bills.payments.store', $bill) }}" class="grid md:grid-cols-4 gap-3">@csrf<input type="number" step="0.01" name="amount" class="border rounded p-2" placeholder="Amount" required><input name="method" class="border rounded p-2" placeholder="Method"><input name="reference" class="border rounded p-2" placeholder="Reference"><button class="bg-green-600 text-white rounded" type="submit">Record</button></form>
            <h4 class="font-semibold mt-6 mb-2">Payments</h4>
            <ul class="space-y-2">@forelse($bill->payments as $payment)<li>{{ number_format($payment->amount,2) }} via {{ $payment->method }} on {{ $payment->paid_at?->format('Y-m-d H:i') }}</li>@empty<li>No payments yet.</li>@endforelse</ul>
        </div>
    </div>
</x-app-layout>
