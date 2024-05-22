<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCaissierRequest extends FormRequest
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
        $caissierId = $this->route('caissierID') ;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $caissierId,
            'phone' => 'required|string|max:20',
            'company_name' => 'required|string|max:20',
        ];
    }
}
