<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Autoriser toutes les requêtes pour cet exemple
        // Vous pouvez ajouter une logique d'autorisation spécifique ici si nécessaire
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
{
    return [
        'name' => 'required|string|max:255',
        'abbreviation' => 'nullable|string|max:10',
        'default_currency' => 'nullable|string|max:10',
        'country' => 'nullable|string|max:100',
        'tax_id' => 'nullable|string|max:50',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'website' => 'nullable|url|max:255',
        'description' => 'nullable|string',
        'gerant_name.*' => 'required|string|max:255',
        'gerant_email.*' => 'required|email|max:255',
        'gerant_phone.*' => 'required|string|max:20',
    ];
}

public function messages()
{
    return [
        'gerant_name.*.required' => 'The manager name field is required.',
        'gerant_email.*.required' => 'The manager email field is required.',
        'gerant_phone.*.required' => 'The manager phone field is required.',
    ];
}

}
