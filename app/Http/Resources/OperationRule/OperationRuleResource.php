<?php

namespace App\Http\Resources\OperationRule;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed operation_if
 * @property mixed operation_status_if
 * @property mixed operation_result_if
 * @property mixed operation_then
 * @property mixed operation_status_then
 * @property mixed operation_result_then
 */
class OperationRuleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'operation_if' => $this->operation_if->verbal_name != null ? $this->operation_if->verbal_name :
                $this->operation_if->imperative_name,
            'operation_status_if' => $this->operation_status_if,
            'operation_result_if' => $this->operation_result_if != null ? $this->operation_result_if->name : null,
            'operation_then' => $this->operation_then->verbal_name != null ? $this->operation_then->verbal_name :
                $this->operation_then->imperative_name,
            'operation_status_then' => $this->operation_status_then,
            'operation_result_then' => $this->operation_result_then != null ? $this->operation_result_then->name : null
        ];
    }
}
