@csrf
<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm">Admission No</label>
        <input name="admission_no" value="{{ old('admission_no', $student->admission_no ?? '') }}" class="w-full border rounded p-2" required>
    </div>
    <div>
        <label class="block text-sm">First Name</label>
        <input name="first_name" value="{{ old('first_name', $student->first_name ?? '') }}" class="w-full border rounded p-2" required>
    </div>
    <div>
        <label class="block text-sm">Last Name</label>
        <input name="last_name" value="{{ old('last_name', $student->last_name ?? '') }}" class="w-full border rounded p-2" required>
    </div>
    <div>
        <label class="block text-sm">Date of Birth</label>
        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', isset($student) && $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block text-sm">Gender</label>
        <input name="gender" value="{{ old('gender', $student->gender ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block text-sm">Status</label>
        <input name="status" value="{{ old('status', $student->status ?? 'active') }}" class="w-full border rounded p-2">
    </div>
</div>

<div class="mt-6 border-t pt-4">
    <h3 class="font-semibold mb-3">Guardian (optional)</h3>
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm">Name</label>
            <input name="guardian_name" value="{{ old('guardian_name', $student->guardian->name ?? '') }}" class="w-full border rounded p-2">
        </div>
        <div>
            <label class="block text-sm">Phone</label>
            <input name="guardian_phone" value="{{ old('guardian_phone', $student->guardian->phone ?? '') }}" class="w-full border rounded p-2">
        </div>
        <div>
            <label class="block text-sm">Email</label>
            <input type="email" name="guardian_email" value="{{ old('guardian_email', $student->guardian->email ?? '') }}" class="w-full border rounded p-2">
        </div>
        <div>
            <label class="block text-sm">Relationship</label>
            <input name="guardian_relationship" value="{{ old('guardian_relationship', $student->guardian->relationship ?? '') }}" class="w-full border rounded p-2">
        </div>
    </div>
</div>

<div class="mt-6">
    <button class="px-4 py-2 bg-blue-600 text-white rounded" type="submit">{{ $buttonText ?? 'Save' }}</button>
</div>
