<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Class Details</h2></x-slot>
    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold">{{ $class->name }} {{ $class->section }}</h3>
            <p>Academic Year: {{ $class->academic_year }}</p>
            <h4 class="font-semibold mt-4">Enrollments</h4>
            <ul class="list-disc pl-6 mt-2">
                @forelse($class->enrollments as $enrollment)
                    <li>{{ $enrollment->student?->full_name }}</li>
                @empty
                    <li>No enrollments yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>
