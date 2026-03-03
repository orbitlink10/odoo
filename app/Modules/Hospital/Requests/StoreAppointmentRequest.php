<?php

namespace App\Modules\Hospital\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        return [
            'patient_id' => ['required', 'exists:hospital_patients,id'],
            'doctor_id' => ['nullable', 'exists:hospital_doctors,id'],
            'appointment_at' => ['required', 'date'],
            'status' => ['nullable', 'string', 'max:30'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
