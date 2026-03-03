@csrf
<div class="grid md:grid-cols-3 gap-4">
    <div>
        <label class="block text-sm">Class Name</label>
        <input name="name" value="{{ old('name', $class->name ?? '') }}" class="w-full border rounded p-2" required>
    </div>
    <div>
        <label class="block text-sm">Section</label>
        <input name="section" value="{{ old('section', $class->section ?? '') }}" class="w-full border rounded p-2">
    </div>
    <div>
        <label class="block text-sm">Academic Year</label>
        <input name="academic_year" value="{{ old('academic_year', $class->academic_year ?? '') }}" class="w-full border rounded p-2">
    </div>
</div>
<div class="mt-6">
    <button class="px-4 py-2 bg-blue-600 text-white rounded" type="submit">{{ $buttonText ?? 'Save' }}</button>
</div>
