<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Visit</h2></x-slot>
    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('hospital.visits.store') }}" class="bg-white shadow sm:rounded-lg p-6 space-y-4">
            @csrf
            <div><label class="block text-sm">Patient</label><select name="patient_id" class="w-full border rounded p-2">@foreach($patients as $patient)<option value="{{ $patient->id }}">{{ $patient->full_name }}</option>@endforeach</select></div>
            <div><label class="block text-sm">Appointment (optional)</label><select name="appointment_id" class="w-full border rounded p-2"><option value="">-- none --</option>@foreach($appointments as $appointment)<option value="{{ $appointment->id }}">{{ $appointment->appointment_at?->format('Y-m-d H:i') }} - {{ $appointment->patient?->full_name }}</option>@endforeach</select></div>
            <div><label class="block text-sm">Visit Time</label><input type="datetime-local" name="visited_at" class="w-full border rounded p-2" required></div>
            <div><label class="block text-sm">Diagnosis</label><textarea name="diagnosis" class="w-full border rounded p-2"></textarea></div>
            <div><label class="block text-sm">Treatment</label><textarea name="treatment" class="w-full border rounded p-2"></textarea></div>
            <button class="px-4 py-2 bg-blue-600 text-white rounded" type="submit">Save Visit</button>
        </form>
    </div>
</x-app-layout>
