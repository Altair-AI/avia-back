<?php

namespace App\Http\Requests\OperationRule;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOperationRuleRequest extends FormRequest
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
            'description' => 'nullable|string',
            'type' => 'required|integer',
            'priority' => 'required|integer',
            'repeat_voice' => 'required|integer',
            'context' => 'required|string',
            'rule_based_knowledge_base_id' => 'required|integer',
            'operation_id_if' => 'required|integer',
            'operation_status_if' => 'required|integer',
            'operation_result_id_if' => 'nullable|integer',
            'operation_id_then' => 'required|integer',
            'operation_status_then' => 'required|integer',
            'operation_result_id_then' => 'nullable|integer',
            'malfunction_cause_id' => 'nullable|integer',
            'malfunction_system_id' => 'required|integer',
            'document_id' => 'required|integer'
        ];
    }
}
