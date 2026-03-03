<?php

namespace App\Modules\Hospital\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHospitalPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:0.01'],
            'method' => ['nullable', 'string', 'max:50'],
            'reference' => ['nullable', 'string', 'max:100'],
        ];
    }
}
