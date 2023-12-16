<?php

namespace App\Http\Requests\RuleEngine;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class InitializeRuleEngineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $roles = [User::SUPER_ADMIN_ROLE, User::ADMIN_ROLE, User::TECHNICIAN_ROLE];
        return (in_array(auth()->user()->role, $roles, true));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'emrg_code' => 'integer|nullable',
            'bsto_code' => 'integer|nullable',
            'sei_code' => 'integer|nullable',
            'local_code' => 'integer|nullable',
            'obs' => 'integer|nullable'
        ];
    }
}
