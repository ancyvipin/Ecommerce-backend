<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
<<<<<<< HEAD
            'user_email' => 'required|email',
            'user_password' => 'required|string',
=======
            // --- User Account Details ---
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|string|email|max:255|unique:users,user_email',
            'user_password' => [
                'required',
                'string',
                'confirmed' // This is crucial for UX
            ],
            'mobile' => 'required|string|max:20',
            'shipping_address_line_1' => 'required|string|max:255',
            'shipping_address_line_2' => 'nullable|string|max:255', // optional
            'shipping_city'           => 'required|string|max:255',
            'shipping_state'          => 'required|string|max:255',
            'shipping_postal_code'    => 'required|string|max:20',
            'shipping_country'        => 'required|string|max:255',
>>>>>>> 141a7ee (Updated project with new controllers, requests, factories, and migrations)
        ];
    }
}
