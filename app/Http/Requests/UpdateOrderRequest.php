<?php

namespace App\Http\Requests;
use App\Rules\CheckStock;
use Illuminate\Foundation\Http\FormRequest;


class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       return [
            'cart' => 'required|array|min:1',
            'cart.*.product_id' => [
                'required',
                'uuid',
                'exists:products,prdt_id',
                // Validate stock for each item in the updated cart
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1];
                    $quantity = $this->input("cart.{$index}.quantity");

                    if (!(new CheckStock($quantity))->passes($attribute, $value)) {
                        $fail((new CheckStock($quantity))->message());
                    }
                },
            ],
            'cart.*.quantity' => 'required|integer|min:1',
          
            'status' => 'nullable|string|in:pending,processing,shipped,completed,cancelled',
        ];
    }
}
