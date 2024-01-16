<?php

namespace App\Http\Requests\OperationRule;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexOperationRuleRequest extends FormRequest
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
            'description' => 'string',
            'type' => 'integer',
            'priority' => 'integer',
            'repeat_voice' => 'integer',
            'context' => 'string',
            'rule_based_knowledge_base_id' => 'integer',
            'operation_id_if' => 'integer',
            'operation_status_if' => 'integer',
            'operation_result_id_if' => 'integer',
            'operation_id_then' => 'integer',
            'operation_status_then' => 'integer',
            'operation_result_id_then' => 'integer',
            'malfunction_cause_id' => 'integer',
            'malfunction_system_id' => 'integer',
            'document_id' => 'integer'
        ];
    }
}
