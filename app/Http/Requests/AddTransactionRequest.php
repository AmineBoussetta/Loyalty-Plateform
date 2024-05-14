<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddTransactionRequest extends FormRequest
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
            'transaction_id' => 'nullable',
            'carte_fidelite_id' => 'required|exists:carte_fidelites,id',
            'transaction_date' => 'required|date',
            'amount' => 'required|numeric',
            'payment_method' => 'required|in:cash,fidelity_points',
        ];
    }
}
