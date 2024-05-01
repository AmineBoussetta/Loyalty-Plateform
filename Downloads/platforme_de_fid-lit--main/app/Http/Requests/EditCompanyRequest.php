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
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'abbreviation' => 'required|max:10',
            'default_currency' => 'required|max:3',
            'country' => 'required|max:255',
            'tax_id' => 'required|max:255',
            'managers' => 'required|max:255',
            'phone' => 'required|max:20',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|max:1000',
        ];
    }
}
