<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Student</h2></x-slot>
    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('school.students.update', $student) }}" class="bg-white shadow sm:rounded-lg p-6">
            @method('PUT')
            @include('modules.school.students._form', ['buttonText' => 'Update Student'])
        </form>
    </div>
</x-app-layout>
