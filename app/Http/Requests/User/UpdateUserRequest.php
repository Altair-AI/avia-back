<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (auth()->user()->role == User::SUPER_ADMIN_ROLE or auth()->user()->role == User::ADMIN_ROLE);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $role_rule = 'required|integer|between:0,2';
        $organization_id_rule = 'required|integer';
        if (auth()->user()->role == User::ADMIN_ROLE) {
            $role_rule = 'required|integer|between:1,2';
            $organization_id_rule = 'integer|in:' . auth()->user()->organization_id;
        }

        return [
            'name' => 'required|string|between:2,100',
            'email' => "required|email|max:100|unique:users,email,{$this->user->id}",
            'password' => 'required|string|confirmed|min:6',
            'role' => $role_rule,
            'status' => 'required|integer|between:0,2',
            'organization_id' => $organization_id_rule
        ];
    }
}
