<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
    public function rules()
{
    return [
        'name' => 'required|max:255',
        'abbreviation' => 'required|max:255',
        'default_currency' => 'required|max:255',
        'country' => 'required|max:255',
        'tax_id' => 'required|max:255',
        'managers' => 'required|max:255',
        'phone' => 'required|max:255',
        'email' => 'required|email|max:255',
        'website' => 'required|url|max:255',
        'description' => 'required',
    ];
}

}
