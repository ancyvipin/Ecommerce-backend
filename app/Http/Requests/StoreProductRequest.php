<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        // For now, allow any authenticated user to create a product.
        // You could add role-based logic here, e.g., return $this->user()->isAdmin();
        return true;
    }

    public function rules(): array
    {
        return [
            // The product name must be provided and must be unique in the products table.
            'prdt_name' => 'required|string|max:255|unique:products,prdt_name',
            'prdt_description' => 'required|string',
            // Price must be a number and cannot be negative.
            'prdt_price' => 'required|numeric|min:1',
            // Stock must be an integer and cannot be negative.
            'stock_quantity' => 'required|integer|min:1',
        
            'prdt_price' => 'required|numeric|min:1',
     
            'stock_quantity' => 'required|integer|min:1',
        ];
    }
}