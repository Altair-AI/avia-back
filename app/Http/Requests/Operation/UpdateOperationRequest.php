<?php

namespace App\Http\Requests\Operation;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOperationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (auth()->user()->role == User::SUPER_ADMIN_ROLE);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'code' => "required|string|max:255|unique:operation",
            'type' => 'required|integer',
            'imperative_name' => 'nullable|string',
            'verbal_name' => 'required|string',
            'description' => 'nullable|string',
            'document_section' => 'required|string|max:255',
            'document_subsection' => 'required|string|max:255',
            'start_document_page' => 'required|integer',
            'end_document_page' => 'nullable|integer',
            'actual_document_page' => 'nullable|integer',
            'document_id' => 'required|integer'
        ];
    }
}
