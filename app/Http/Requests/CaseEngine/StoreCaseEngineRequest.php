<?php

namespace App\Http\Requests\CaseEngine;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCaseEngineRequest extends FormRequest
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
            'date' => 'required|date',
            'card_number' => 'required|string|max:255',
            'operation_time_from_start' => 'nullable|integer',
            'operation_time_from_last_repair' => 'nullable|integer',
            'malfunction_detection_stage_id' => 'required|integer',
            'real_time_technical_system_id' => 'required|integer',
            'work_session_id' => 'required|integer'
        ];
    }
}
