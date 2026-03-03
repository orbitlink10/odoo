<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Student Details</h2></x-slot>
    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold">{{ $student->full_name }}</h3>
            <p>Admission: {{ $student->admission_no }}</p>
            <p>Status: {{ $student->status }}</p>
            <p>Guardian: {{ $student->guardian?->name ?? '-' }}</p>
        </div>

        <div class="bg-white shadow sm:rounded-lg p-6">
            <h4 class="font-semibold mb-3">Fee Invoices</h4>
            <ul class="space-y-2">
                @forelse($student->feeInvoices as $invoice)
                    <li>
                        <a class="text-blue-600" href="{{ route('school.fee-invoices.show', $invoice) }}">{{ $invoice->invoice_no }}</a>
                        - Balance {{ number_format($invoice->balance, 2) }}
                    </li>
                @empty
                    <li>No fee invoices yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>
