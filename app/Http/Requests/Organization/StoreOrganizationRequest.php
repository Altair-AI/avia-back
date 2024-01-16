<?php

namespace App\Http\Requests\Organization;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->role === User::SUPER_ADMIN_ROLE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:organization',
            'description' => 'nullable|string',
            'actual_address' => 'nullable|string',
            'legal_address' => 'nullable|string',
            'tin' => 'nullable|string',
            'rboc' => 'nullable|string',
            'psrn' => 'nullable|string',
            'phone' => 'nullable|string',
            'bank_account' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'bik' => 'nullable|string',
            'correspondent_account' => 'nullable|string',
            'full_director_name' => 'nullable|string',
            'treaty_number' => 'nullable|string',
            'treaty_date' => 'nullable|date'
        ];
    }
}
