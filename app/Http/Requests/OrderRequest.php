<?php

namespace App\Http\Requests;

use App\Rules\CheckStock; // <-- Import the custom rule
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'cart' => 'required|array|min:1',
            'cart.*.product_id' => [
                'required',
                'uuid',
                'exists:products,prdt_id',
                // For each product_id, we apply our custom stock check rule.
                // We pass it the quantity for that specific item in the cart.
                function ($attribute, $value, $fail) {
                    // Extract the index 'n' from 'cart.n.product_id'
                    $index = explode('.', $attribute)[1];
                    // Get the quantity from the corresponding item in the cart
                    $quantity = $this->input("cart.{$index}.quantity");

                    // Use the custom rule directly
                    if (!(new CheckStock($quantity))->passes($attribute, $value)) {
                        $fail((new CheckStock($quantity))->message());
                    }
                },
            ],
            'cart.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'cart.required' => 'Your shopping cart cannot be empty.',
            'cart.*.product_id.exists' => 'An item in your cart is no longer available.',
        ];
    }
}