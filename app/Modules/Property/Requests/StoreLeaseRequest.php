<?php

namespace App\Modules\Property\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        return [
            'unit_id' => ['required', 'exists:property_units,id'],
            'tenant_name' => ['required', 'string', 'max:255'],
            'tenant_phone' => ['nullable', 'string', 'max:20'],
            'tenant_email' => ['nullable', 'email', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
            'rent_amount' => ['required', 'numeric', 'min:0'],
            'deposit_amount' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
