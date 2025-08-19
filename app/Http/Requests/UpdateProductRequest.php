<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
        // Get the product's UUID from the route, e.g., /api/products/{product}
        $productId = $this->route('product')->prdt_id;

        return [
<<<<<<< HEAD
            // 'sometimes' means only validate this field if it's present in the request.
=======
>>>>>>> 141a7ee (Updated project with new controllers, requests, factories, and migrations)
            'prdt_name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                // This rule ensures the name is unique, EXCEPT for the product we're currently editing.
                Rule::unique('products', 'prdt_name')->ignore($productId, 'prdt_id'),
            ],
            'prdt_description' => 'sometimes|required|string',
            'prdt_price' => 'sometimes|required|numeric|min:0',
            'stock_quantity' => 'sometimes|required|integer|min:0',
        ];
    
    }
}
