<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Students</h2>
            <a href="{{ route('school.students.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Add Student</a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow sm:rounded-lg overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left p-3">Admission #</th>
                        <th class="text-left p-3">Name</th>
                        <th class="text-left p-3">Guardian</th>
                        <th class="text-left p-3">Status</th>
                        <th class="text-left p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr class="border-t">
                            <td class="p-3">{{ $student->admission_no }}</td>
                            <td class="p-3">{{ $student->full_name }}</td>
                            <td class="p-3">{{ $student->guardian?->name ?? '-' }}</td>
                            <td class="p-3">{{ $student->status }}</td>
                            <td class="p-3 flex gap-3">
                                <a class="text-blue-600" href="{{ route('school.students.show', $student) }}">View</a>
                                <a class="text-amber-600" href="{{ route('school.students.edit', $student) }}">Edit</a>
                                <form method="POST" action="{{ route('school.students.destroy', $student) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="p-3" colspan="5">No students found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $students->links() }}</div>
    </div>
</x-app-layout>
