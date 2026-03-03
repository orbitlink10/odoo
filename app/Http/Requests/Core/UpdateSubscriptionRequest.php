<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        return [
            'plan_id' => ['nullable', Rule::exists('plans', 'id')],
            'modules' => ['required', 'array', 'min:1'],
            'modules.*' => ['string', Rule::in(['school', 'hospital', 'property', 'pos'])],
            'start_trial' => ['nullable', 'boolean'],
            'trial_days' => ['nullable', 'integer', 'min:1', 'max:30'],
        ];
    }
}
