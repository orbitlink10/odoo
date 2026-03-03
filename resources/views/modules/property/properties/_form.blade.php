@csrf
<div class="grid md:grid-cols-3 gap-4">
    <div><label class="block text-sm">Name</label><input name="name" value="{{ old('name', $property->name ?? '') }}" class="w-full border rounded p-2" required></div>
    <div><label class="block text-sm">Type</label><input name="type" value="{{ old('type', $property->type ?? '') }}" class="w-full border rounded p-2"></div>
    <div><label class="block text-sm">Location</label><input name="location" value="{{ old('location', $property->location ?? '') }}" class="w-full border rounded p-2"></div>
</div>
<div class="mt-6"><button class="px-4 py-2 bg-blue-600 text-white rounded" type="submit">{{ $buttonText ?? 'Save' }}</button></div>
