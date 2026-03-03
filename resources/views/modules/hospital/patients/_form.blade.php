@csrf
<div class="grid md:grid-cols-2 gap-4">
    <div><label class="block text-sm">Patient No</label><input name="patient_no" value="{{ old('patient_no', $patient->patient_no ?? '') }}" class="w-full border rounded p-2" required></div>
    <div><label class="block text-sm">First Name</label><input name="first_name" value="{{ old('first_name', $patient->first_name ?? '') }}" class="w-full border rounded p-2" required></div>
    <div><label class="block text-sm">Last Name</label><input name="last_name" value="{{ old('last_name', $patient->last_name ?? '') }}" class="w-full border rounded p-2" required></div>
    <div><label class="block text-sm">Date of Birth</label><input type="date" name="date_of_birth" value="{{ old('date_of_birth', isset($patient) && $patient->date_of_birth ? $patient->date_of_birth->format('Y-m-d') : '') }}" class="w-full border rounded p-2"></div>
    <div><label class="block text-sm">Gender</label><input name="gender" value="{{ old('gender', $patient->gender ?? '') }}" class="w-full border rounded p-2"></div>
    <div><label class="block text-sm">Phone</label><input name="phone" value="{{ old('phone', $patient->phone ?? '') }}" class="w-full border rounded p-2"></div>
    <div><label class="block text-sm">Email</label><input type="email" name="email" value="{{ old('email', $patient->email ?? '') }}" class="w-full border rounded p-2"></div>
    <div class="md:col-span-2"><label class="block text-sm">Address</label><textarea name="address" class="w-full border rounded p-2">{{ old('address', $patient->address ?? '') }}</textarea></div>
</div>
<div class="mt-6"><button class="px-4 py-2 bg-blue-600 text-white rounded" type="submit">{{ $buttonText ?? 'Save' }}</button></div>
