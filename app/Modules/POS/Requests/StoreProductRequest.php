<?php

namespace App\Modules\POS\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        return [
            'category_id' => ['nullable', 'exists:pos_categories,id'],
            'sku' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'tax_rate' => ['nullable', 'numeric', 'min:0'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
