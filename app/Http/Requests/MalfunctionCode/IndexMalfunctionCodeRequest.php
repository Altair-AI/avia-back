<?php

namespace App\Http\Requests\MalfunctionCode;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexMalfunctionCodeRequest extends FormRequest
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
            'name' => 'string',
            'type' => 'string',
            'source' => 'string|max:255',
            'alternative_name' => 'string',
            'technical_system_id' => 'integer'
        ];
    }
}
