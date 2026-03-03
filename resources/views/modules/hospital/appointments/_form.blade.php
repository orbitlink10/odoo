@csrf
<div class="grid md:grid-cols-2 gap-4">
    <div><label class="block text-sm">Patient</label><select name="patient_id" class="w-full border rounded p-2" required>@foreach($patients as $patient)<option value="{{ $patient->id }}" @selected(old('patient_id', $appointment->patient_id ?? '') == $patient->id)>{{ $patient->full_name }}</option>@endforeach</select></div>
    <div><label class="block text-sm">Doctor</label><select name="doctor_id" class="w-full border rounded p-2"><option value="">-- None --</option>@foreach($doctors as $doctor)<option value="{{ $doctor->id }}" @selected(old('doctor_id', $appointment->doctor_id ?? '') == $doctor->id)>{{ $doctor->name }}</option>@endforeach</select></div>
    <div><label class="block text-sm">Appointment Time</label><input type="datetime-local" name="appointment_at" value="{{ old('appointment_at', isset($appointment) && $appointment->appointment_at ? $appointment->appointment_at->format('Y-m-d\\TH:i') : '') }}" class="w-full border rounded p-2" required></div>
    <div><label class="block text-sm">Status</label><input name="status" value="{{ old('status', $appointment->status ?? 'scheduled') }}" class="w-full border rounded p-2"></div>
    <div class="md:col-span-2"><label class="block text-sm">Notes</label><textarea name="notes" class="w-full border rounded p-2">{{ old('notes', $appointment->notes ?? '') }}</textarea></div>
</div>
<div class="mt-6"><button class="px-4 py-2 bg-blue-600 text-white rounded" type="submit">{{ $buttonText ?? 'Save' }}</button></div>
