<?php

namespace App\Http\Requests\RealTimeTechnicalSystem;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexRealTimeTechnicalSystemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->role !== User::GUEST_ROLE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'registration_code' => 'string|max:255',
            'registration_description' => 'string',
            'operation_time_from_start' => 'integer',
            'operation_time_from_last_repair' => 'integer',
            'technical_system_id' => 'integer',
            'project_id' => 'integer'
        ];
    }
}
