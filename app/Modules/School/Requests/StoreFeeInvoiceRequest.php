<?php

namespace App\Modules\School\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeeInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        return [
            'student_id' => ['required', 'exists:school_students,id'],
            'fee_name' => ['required', 'string', 'max:255'],
            'term' => ['nullable', 'string', 'max:50'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'due_date' => ['nullable', 'date'],
        ];
    }
}
