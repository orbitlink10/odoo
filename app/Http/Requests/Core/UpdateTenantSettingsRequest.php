<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTenantSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'size:2'],
            'timezone' => ['required', 'string', 'max:64'],
            'currency' => ['required', 'string', 'size:3'],
            'logo_path' => ['nullable', 'string', 'max:255'],
            'sms_provider' => ['nullable', 'string', 'max:100'],
            'email_provider' => ['nullable', 'string', 'max:100'],
            'vat_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
