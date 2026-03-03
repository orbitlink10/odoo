<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Fee Invoice {{ $feeInvoice->invoice_no }}</h2></x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <p>Student: {{ $feeInvoice->student?->full_name }}</p>
            <p>Amount: {{ number_format($feeInvoice->amount, 2) }}</p>
            <p>Paid: {{ number_format($feeInvoice->paid_amount, 2) }}</p>
            <p>Balance: {{ number_format($feeInvoice->balance, 2) }}</p>
            <p>Status: {{ $feeInvoice->status }}</p>
        </div>

        <div class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="font-semibold mb-4">Record Payment</h3>
            <form method="POST" action="{{ route('school.fee-invoices.payments.store', $feeInvoice) }}" class="grid md:grid-cols-4 gap-3">
                @csrf
                <input name="amount" type="number" step="0.01" placeholder="Amount" class="border rounded p-2" required>
                <input name="method" placeholder="Method" class="border rounded p-2">
                <input name="reference" placeholder="Reference" class="border rounded p-2">
                <button class="bg-green-600 text-white rounded px-4" type="submit">Save Payment</button>
            </form>

            <h4 class="font-semibold mt-6 mb-2">Payment History</h4>
            <ul class="space-y-2">
                @forelse($feeInvoice->payments as $payment)
                    <li>{{ number_format($payment->amount, 2) }} via {{ $payment->method }} on {{ $payment->paid_at?->format('Y-m-d H:i') }}</li>
                @empty
                    <li>No payments yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>
