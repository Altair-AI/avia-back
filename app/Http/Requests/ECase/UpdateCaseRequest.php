<?php

namespace App\Http\Requests\ECase;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCaseRequest extends FormRequest
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
            'card_number' => 'required|string|max:255',
            'operation_time_from_start' => 'nullable|integer',
            'operation_time_from_last_repair' => 'nullable|integer',
            'malfunction_detection_stage_id' => 'required|integer'
        ];
    }
}
