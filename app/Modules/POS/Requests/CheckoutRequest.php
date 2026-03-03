<?php

namespace App\Modules\POS\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['nullable', 'string', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:20'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['nullable', 'exists:pos_products,id'],
            'items.*.quantity' => ['nullable', 'numeric', 'min:0.01'],
            'discount_total' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['nullable', 'string', 'max:50'],
            'paid_amount' => ['required', 'numeric', 'min:0.01'],
        ];
    }
}
