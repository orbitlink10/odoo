<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class RecordInvoicePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        return [
            'invoice_id' => ['required', 'exists:invoices,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'method' => ['nullable', 'string', 'max:40'],
            'reference' => ['nullable', 'string', 'max:100'],
        ];
    }
}
