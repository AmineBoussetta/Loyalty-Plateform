<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCaissierRequest extends FormRequest
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
            'Caissier_ID' => 'required|unique:caissiers,Caissier_ID',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users',
            'company_name' => 'required',
        ];
    }
}    
