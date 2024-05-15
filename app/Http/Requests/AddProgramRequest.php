<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProgramRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'expiry_date' => 'required|date|after:start_date',
            'amount' => 'required|numeric',
            'points' => 'required|integer',
            'minimum_amount' => 'nullable|numeric',
            'conversion_factor' => 'nullable|numeric',
            'comment' => 'nullable|string|max:500',
            'status' => 'nullable',
        ];
    }
}
