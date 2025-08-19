<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterOrdersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
       return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'from_date'=>'nullable|date',
            'to_date'=>'nullable|date|after_or_equal:from_date',
        ];
    }
    public function messages(): array
    {
        return [
            'to_date.after_or_equal' => 'The "to date" must be a date after or equal to the "from date".',
        ];
    }
}
