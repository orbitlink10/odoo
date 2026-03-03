<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">School Reports</h2></x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="grid md:grid-cols-2 gap-4">
            <div class="bg-white shadow sm:rounded-lg p-5">
                <p class="text-sm text-gray-500">Total Paid</p>
                <p class="text-3xl font-bold">{{ number_format($totalPaid, 2) }}</p>
            </div>
            <div class="bg-white shadow sm:rounded-lg p-5">
                <p class="text-sm text-gray-500">Outstanding</p>
                <p class="text-3xl font-bold">{{ number_format($outstanding, 2) }}</p>
            </div>
        </div>

        <div class="bg-white shadow sm:rounded-lg p-5">
            <h3 class="font-semibold mb-3">Outstanding Invoices</h3>
            <ul class="space-y-2">
                @forelse($unpaidInvoices as $invoice)
                    <li>{{ $invoice->invoice_no }} - {{ $invoice->student?->full_name }} - {{ number_format($invoice->balance, 2) }}</li>
                @empty
                    <li>No outstanding invoices.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>
