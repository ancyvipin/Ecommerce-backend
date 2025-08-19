<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FrequencyReportRequest extends FormRequest
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
            
            'from_date' => 'nullable|date',
            'to_date'   => 'nullable|date|after_or_equal:from_date',
            // Add an optional limit to get the top N products
            'limit'     => 'nullable|integer|min:1|max:100',
        ];
    }
}
