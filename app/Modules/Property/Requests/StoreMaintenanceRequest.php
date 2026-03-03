<?php

namespace App\Modules\Property\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaintenanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        return [
            'unit_id' => ['nullable', 'exists:property_units,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:30'],
            'priority' => ['nullable', 'string', 'max:30'],
        ];
    }
}
