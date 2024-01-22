<?php

namespace App\Http\Requests\MalfunctionCode;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMalfunctionCodeRequest extends FormRequest
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
            'name' => 'required|string',
            'type' => 'required|integer',
            'source' => 'nullable|string|max:255',
            'alternative_name' => 'nullable|string',
            'technical_system_id' => 'required|integer'
        ];
    }
}
