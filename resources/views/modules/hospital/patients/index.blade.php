<x-app-layout>
    <x-slot name="header"><div class="flex justify-between items-center"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Patients</h2><a class="px-4 py-2 bg-blue-600 text-white rounded" href="{{ route('hospital.patients.create') }}">Add Patient</a></div></x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50"><tr><th class="p-3 text-left">Patient No</th><th class="p-3 text-left">Name</th><th class="p-3 text-left">Phone</th><th class="p-3 text-left">Actions</th></tr></thead>
                <tbody>
                @forelse($patients as $patient)
                    <tr class="border-t"><td class="p-3">{{ $patient->patient_no }}</td><td class="p-3">{{ $patient->full_name }}</td><td class="p-3">{{ $patient->phone }}</td><td class="p-3 flex gap-3"><a class="text-blue-600" href="{{ route('hospital.patients.show', $patient) }}">View</a><a class="text-amber-600" href="{{ route('hospital.patients.edit', $patient) }}">Edit</a></td></tr>
                @empty
                    <tr><td class="p-3" colspan="4">No patients available.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $patients->links() }}</div>
    </div>
</x-app-layout>
