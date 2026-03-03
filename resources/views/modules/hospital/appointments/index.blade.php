<x-app-layout>
    <x-slot name="header"><div class="flex justify-between items-center"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Appointments</h2><a href="{{ route('hospital.appointments.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Schedule</a></div></x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg overflow-hidden">
            <table class="min-w-full text-sm"><thead class="bg-gray-50"><tr><th class="p-3 text-left">Date</th><th class="p-3 text-left">Patient</th><th class="p-3 text-left">Doctor</th><th class="p-3 text-left">Status</th><th class="p-3 text-left">Action</th></tr></thead><tbody>
                @forelse($appointments as $appointment)
                    <tr class="border-t"><td class="p-3">{{ $appointment->appointment_at?->format('Y-m-d H:i') }}</td><td class="p-3">{{ $appointment->patient?->full_name }}</td><td class="p-3">{{ $appointment->doctor?->name }}</td><td class="p-3">{{ $appointment->status }}</td><td class="p-3"><a class="text-blue-600" href="{{ route('hospital.appointments.show', $appointment) }}">View</a></td></tr>
                @empty
                    <tr><td class="p-3" colspan="5">No appointments.</td></tr>
                @endforelse
            </tbody></table>
        </div>
        <div class="mt-4">{{ $appointments->links() }}</div>
    </div>
</x-app-layout>
