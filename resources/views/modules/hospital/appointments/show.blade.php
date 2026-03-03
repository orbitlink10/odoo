<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Appointment Details</h2></x-slot>
    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8"><div class="bg-white shadow sm:rounded-lg p-6"><p>Patient: {{ $appointment->patient?->full_name }}</p><p>Doctor: {{ $appointment->doctor?->name }}</p><p>Date: {{ $appointment->appointment_at?->format('Y-m-d H:i') }}</p><p>Status: {{ $appointment->status }}</p><p>Notes: {{ $appointment->notes }}</p></div></div>
</x-app-layout>
