<?php

namespace App\Http\Requests\TechnicalSystem;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexTechnicalSystemRequest extends FormRequest
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
        return [
            'code' => 'string|max:255',
            'name' => 'string',
            'parent_technical_system_id' => 'integer'
        ];
    }
}
