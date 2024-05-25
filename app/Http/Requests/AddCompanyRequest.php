<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // You can add authorization logic here. For now, let's allow all users.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
{
    return [
        'name' => 'required|max:255',
        'abbreviation' => 'nullable|max:255',
        'default_currency' => 'nullable|max:255',
        'country' => 'nullable|max:255',
        'tax_id' => 'nullable|max:255',
        'phone' => 'nullable|max:255',
        'email' => 'nullable|email|max:255',
        'website' => 'nullable|url|max:255',
        'description' => 'nullable',
        'gerants.*.name' => 'required|max:255', // Validate each gerant's name
        'gerants.*.email' => 'required|email|max:255', // Validate each gerant's email
        'gerants.*.phone' => 'required|max:255', // Validate each gerant's phone
    ];
}

}
