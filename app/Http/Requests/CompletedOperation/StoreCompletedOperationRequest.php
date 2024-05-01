<?php

namespace App\Http\Requests\CompletedOperation;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompletedOperationRequest extends FormRequest
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
            'operation_id' => 'required|integer',
            'previous_operation_id' => 'integer',
            'operation_status' => 'required|integer',
            'operation_result_id' => 'integer',
            'work_session_id' => 'required|integer'
        ];
    }
}
