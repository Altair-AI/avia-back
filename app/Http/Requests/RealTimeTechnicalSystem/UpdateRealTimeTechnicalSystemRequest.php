<?php

namespace App\Http\Requests\RealTimeTechnicalSystem;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRealTimeTechnicalSystemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->role === User::SUPER_ADMIN_ROLE or auth()->user()->role === User::ADMIN_ROLE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'registration_code' => 'required|string|max:255|unique:real_time_technical_system',
            'registration_description' => 'nullable|string',
            'operation_time_from_start' => 'nullable|integer',
            'operation_time_from_last_repair' => 'nullable|integer',
            'technical_system_id' => 'required|integer',
            'project_id' => 'required|integer'
        ];
    }
}
