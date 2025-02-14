<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProgramRequest extends FormRequest
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
            'points' => 'required|numeric',
            'minimum_amount' => 'nullable|numeric',
            'amount_premium' => 'required|numeric',
            'points_premium' => 'required|integer',
            'minimum_amount_premium' => 'nullable|numeric',
            'conversion_factor' => 'nullable|numeric',
            'comment' => 'nullable|string|max:500',
            'status' => 'nullable',
        ];
    }
}
