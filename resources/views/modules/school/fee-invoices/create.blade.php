<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Fee Invoice</h2></x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('school.fee-invoices.store') }}" class="bg-white shadow sm:rounded-lg p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm">Student</label>
                <select name="student_id" class="w-full border rounded p-2" required>
                    <option value="">Select Student</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->full_name }} ({{ $student->admission_no }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm">Fee Name</label>
                <input name="fee_name" class="w-full border rounded p-2" required>
            </div>
            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm">Term</label>
                    <input name="term" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block text-sm">Amount</label>
                    <input name="amount" type="number" step="0.01" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block text-sm">Due Date</label>
                    <input name="due_date" type="date" class="w-full border rounded p-2">
                </div>
            </div>
            <button class="px-4 py-2 bg-blue-600 text-white rounded" type="submit">Create Invoice</button>
        </form>
    </div>
</x-app-layout>
