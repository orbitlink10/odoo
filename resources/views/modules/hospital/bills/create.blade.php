<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Bill</h2></x-slot>
    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('hospital.bills.store') }}" class="bg-white shadow sm:rounded-lg p-6 space-y-4">
            @csrf
            <div><label class="block text-sm">Patient</label><select name="patient_id" class="w-full border rounded p-2">@foreach($patients as $patient)<option value="{{ $patient->id }}">{{ $patient->full_name }}</option>@endforeach</select></div>
            <div><label class="block text-sm">Description</label><input name="description" class="w-full border rounded p-2" required></div>
            <div class="grid md:grid-cols-2 gap-4"><div><label class="block text-sm">Quantity</label><input type="number" name="quantity" class="w-full border rounded p-2" value="1"></div><div><label class="block text-sm">Unit Price</label><input type="number" step="0.01" name="unit_price" class="w-full border rounded p-2"></div></div>
            <button class="px-4 py-2 bg-blue-600 text-white rounded" type="submit">Save Bill</button>
        </form>
    </div>
</x-app-layout>
