<?php

namespace App\Modules\Property\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRentInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        return [
            'lease_id' => ['required', 'exists:property_leases,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'due_date' => ['required', 'date'],
        ];
    }
}
