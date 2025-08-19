<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateUserRequest extends FormRequest
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
       $userId = $this->route('user')->id;

        return [
            // Using 'sometimes' so only fields present in the request are validated.
            'user_name' => 'sometimes|required|string|max:255',
            'user_email' => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:255',
                // Make sure the email is unique, ignoring the current user.
                Rule::unique('users', 'user_email')->ignore($userId),
            ],
            'mobile' => 'sometimes|required|string|max:20',
            'shipping_address_line_1' => 'sometimes|required|string|max:255',
            'shipping_address_line_2' => 'sometimes|nullable|string|max:255', // optional
            'shipping_city'           => 'sometimes|required|string|max:255',
            'shipping_state'          => 'sometimes|required|string|max:255',
            'shipping_postal_code'    => 'sometimes|required|string|max:20',
            'shipping_country'        => 'sometimes|required|string|max:255'
        ];
    }
}
