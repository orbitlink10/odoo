<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Classes</h2>
            <a href="{{ route('school.classes.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Add Class</a>
        </div>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Section</th>
                        <th class="p-3 text-left">Academic Year</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $class)
                        <tr class="border-t">
                            <td class="p-3">{{ $class->name }}</td>
                            <td class="p-3">{{ $class->section }}</td>
                            <td class="p-3">{{ $class->academic_year }}</td>
                            <td class="p-3 flex gap-2">
                                <a class="text-blue-600" href="{{ route('school.classes.show', $class) }}">View</a>
                                <a class="text-amber-600" href="{{ route('school.classes.edit', $class) }}">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="p-3" colspan="4">No classes found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $classes->links() }}</div>
    </div>
</x-app-layout>
