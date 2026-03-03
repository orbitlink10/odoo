<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Property Dashboard</h2>
            <div class="text-sm text-gray-500">Rental operations summary</div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="bg-white border border-gray-200 rounded-xl p-5"><p class="text-sm text-gray-500">Properties</p><p class="text-3xl font-bold">{{ $propertyCount }}</p></div>
            <div class="bg-white border border-gray-200 rounded-xl p-5"><p class="text-sm text-gray-500">Units Occupied</p><p class="text-3xl font-bold">{{ $occupiedUnits }}/{{ $totalUnits }}</p></div>
            <div class="bg-white border border-gray-200 rounded-xl p-5"><p class="text-sm text-gray-500">Occupancy Rate</p><p class="text-3xl font-bold">{{ $occupancyRate }}%</p></div>
            <div class="bg-white border border-gray-200 rounded-xl p-5"><p class="text-sm text-gray-500">Arrears</p><p class="text-3xl font-bold">KES {{ number_format($arrearsTotal, 2) }}</p></div>
        </div>

        <div class="grid lg:grid-cols-2 gap-5">
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h3 class="font-bold text-lg">Leases Expiring Soon</h3>
                <ul class="mt-3 divide-y divide-gray-100 text-sm">
                    @forelse($expiringLeases as $lease)
                        <li class="py-2 flex justify-between gap-2">
                            <span>{{ $lease->rentalTenant?->name ?? 'Tenant' }} - {{ $lease->unit?->unit_no }}</span>
                            <span class="text-gray-500">{{ $lease->end_date?->format('Y-m-d') }}</span>
                        </li>
                    @empty
                        <li class="py-2 text-gray-500">No leases expiring in the next 45 days.</li>
                    @endforelse
                </ul>
                <div class="mt-4 flex flex-wrap gap-3 text-sm">
                    <a class="px-3 py-2 rounded-lg bg-blue-600 text-white" href="{{ route('property.leases.create') }}">Create Lease</a>
                    <a class="px-3 py-2 rounded-lg border border-gray-200" href="{{ route('property.leases.index') }}">View Leases</a>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h3 class="font-bold text-lg">Maintenance</h3>
                <p class="mt-2 text-sm text-gray-600">Open/In-progress maintenance requests: <span class="font-semibold text-gray-800">{{ $openMaintenanceCount }}</span></p>
                <div class="mt-4 flex flex-wrap gap-3 text-sm">
                    <a class="px-3 py-2 rounded-lg bg-blue-600 text-white" href="{{ route('property.maintenance.create') }}">New Request</a>
                    <a class="px-3 py-2 rounded-lg border border-gray-200" href="{{ route('property.maintenance.index') }}">Track Requests</a>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <h3 class="font-bold text-lg">Recent Rent Invoices</h3>
            <div class="mt-3 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="text-left p-3">Invoice</th>
                            <th class="text-left p-3">Tenant</th>
                            <th class="text-left p-3">Amount</th>
                            <th class="text-left p-3">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentRentInvoices as $invoice)
                            <tr class="border-t">
                                <td class="p-3"><a class="text-blue-600" href="{{ route('property.rent-invoices.show', $invoice) }}">{{ $invoice->invoice_no }}</a></td>
                                <td class="p-3">{{ $invoice->lease?->rentalTenant?->name }}</td>
                                <td class="p-3">KES {{ number_format($invoice->amount, 2) }}</td>
                                <td class="p-3 font-semibold">KES {{ number_format($invoice->balance, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td class="p-3 text-gray-500" colspan="4">No rent invoices yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
