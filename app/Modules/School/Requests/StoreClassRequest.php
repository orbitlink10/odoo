<?php

namespace App\Modules\School\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'section' => ['nullable', 'string', 'max:100'],
            'academic_year' => ['nullable', 'string', 'max:20'],
        ];
    }
}
