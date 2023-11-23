<?php

namespace App\Http\Requests\Operation;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexOperationRequest extends FormRequest
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
            'type' => 'integer',
            'imperative_name' => 'string',
            'verbal_name' => 'string',
            'document_section' => 'string|max:255',
            'document_subsection' => 'string|max:255',
            'start_document_page' => 'integer',
            'end_document_page' => 'integer',
            'actual_document_page' => 'integer',
            'document_id' => 'integer'
        ];
    }
}
