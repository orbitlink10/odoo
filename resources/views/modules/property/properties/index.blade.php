<x-app-layout>
    <x-slot name="header"><div class="flex justify-between items-center"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Properties</h2><a class="px-4 py-2 bg-blue-600 text-white rounded" href="{{ route('property.properties.create') }}">Add Property</a></div></x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg overflow-hidden">
            <table class="min-w-full text-sm"><thead class="bg-gray-50"><tr><th class="p-3 text-left">Name</th><th class="p-3 text-left">Type</th><th class="p-3 text-left">Location</th><th class="p-3 text-left">Action</th></tr></thead><tbody>@forelse($properties as $property)<tr class="border-t"><td class="p-3">{{ $property->name }}</td><td class="p-3">{{ $property->type }}</td><td class="p-3">{{ $property->location }}</td><td class="p-3"><a class="text-blue-600" href="{{ route('property.properties.show', $property) }}">View</a></td></tr>@empty<tr><td class="p-3" colspan="4">No properties.</td></tr>@endforelse</tbody></table>
        </div>
        <div class="mt-4">{{ $properties->links() }}</div>
    </div>
</x-app-layout>
