<?php

namespace App\Http\Requests\RuleEngine;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RunRuleEngineRequest extends FormRequest
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
            'work_session' => 'required|integer',
            'operation_status' => 'integer|nullable',
            'operation_result' => 'integer|nullable'
        ];
    }
}
