<?php

namespace App\Http\Requests\ECase;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexCaseRequest extends FormRequest
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
            'date' => 'string',
            'card_number' => 'string',
            'operation_time_from_start' => 'integer',
            'operation_time_from_last_repair' => 'integer',
            'malfunction_detection_stage_id' => 'integer',
            'malfunction_cause_id' => 'integer',
            'system_id_for_repair' => 'integer',
            'initial_completed_operation_id' => 'integer',
            'case_based_knowledge_base_id' => 'integer'
        ];
    }
}
