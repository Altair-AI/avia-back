<?php

namespace App\Http\Requests\CaseBasedKnowledgeBase;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCaseBasedKnowledgeBaseRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|integer',
            'correctness' => 'required|integer',
            'author' => 'required|integer',
            'real_time_technical_system_id' => 'required|integer',
            'project_id' => 'required|integer'
        ];
    }
}
