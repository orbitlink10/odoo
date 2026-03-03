<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Hospital Dashboard</h2>
            <div class="text-sm text-gray-500">Clinical and billing overview</div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="bg-white border border-gray-200 rounded-xl p-5"><p class="text-sm text-gray-500">Patients</p><p class="text-3xl font-bold">{{ $patientCount }}</p></div>
            <div class="bg-white border border-gray-200 rounded-xl p-5"><p class="text-sm text-gray-500">Appointments Today</p><p class="text-3xl font-bold">{{ $appointmentsToday }}</p></div>
            <div class="bg-white border border-gray-200 rounded-xl p-5"><p class="text-sm text-gray-500">Today Revenue</p><p class="text-3xl font-bold">KES {{ number_format($todayRevenue, 2) }}</p></div>
            <div class="bg-white border border-gray-200 rounded-xl p-5"><p class="text-sm text-gray-500">Pending Bills</p><p class="text-3xl font-bold">{{ $pendingBillCount }}</p></div>
        </div>

        <div class="grid lg:grid-cols-2 gap-5">
            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h3 class="font-bold text-lg">Upcoming Appointments</h3>
                <ul class="mt-3 divide-y divide-gray-100 text-sm">
                    @forelse($upcomingAppointments as $appointment)
                        <li class="py-2 flex justify-between gap-2">
                            <span>{{ $appointment->patient?->full_name ?? 'N/A' }}</span>
                            <span class="text-gray-500">{{ $appointment->appointment_at?->format('d M H:i') }}</span>
                        </li>
                    @empty
                        <li class="py-2 text-gray-500">No upcoming appointments.</li>
                    @endforelse
                </ul>
                <div class="mt-4 flex flex-wrap gap-3 text-sm">
                    <a class="px-3 py-2 rounded-lg bg-blue-600 text-white" href="{{ route('hospital.appointments.create') }}">Schedule Appointment</a>
                    <a class="px-3 py-2 rounded-lg border border-gray-200" href="{{ route('hospital.appointments.index') }}">View All</a>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-5">
                <h3 class="font-bold text-lg">Recent Patients</h3>
                <ul class="mt-3 divide-y divide-gray-100 text-sm">
                    @forelse($recentPatients as $patient)
                        <li class="py-2 flex justify-between gap-2">
                            <span>{{ $patient->full_name }}</span>
                            <span class="text-gray-500">{{ $patient->patient_no }}</span>
                        </li>
                    @empty
                        <li class="py-2 text-gray-500">No patient records yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h3 class="font-bold text-lg">Billing Snapshot</h3>
                <a href="{{ route('hospital.bills.index') }}" class="text-sm text-blue-600">Open Billing</a>
            </div>
            <p class="mt-2 text-sm text-gray-600">Total unpaid amount across all patient bills: <span class="font-semibold text-gray-800">KES {{ number_format($unpaidBills, 2) }}</span></p>
        </div>
    </div>
</x-app-layout>
