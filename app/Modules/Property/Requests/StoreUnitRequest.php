<?php

namespace App\Modules\Property\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:property_properties,id'],
            'unit_no' => ['required', 'string', 'max:50'],
            'rent_amount' => ['required', 'numeric', 'min:0'],
            'status' => ['nullable', 'string', 'max:30'],
        ];
    }
}
