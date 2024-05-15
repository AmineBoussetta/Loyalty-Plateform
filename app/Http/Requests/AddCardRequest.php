<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCardRequest extends FormRequest
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
            'commercial_ID' => 'unique:carte_fidelites,commercial_ID',
            'points_sum' => 'required|numeric',
            'tier' => 'required',
            'holder_name' => 'required',
            'client_id' => 'nullable',
            'program_id' => 'nullable',
            'fidelity_program' => 'required',
        ];
    }
}
