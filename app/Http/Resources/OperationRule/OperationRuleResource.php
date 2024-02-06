<?php

namespace App\Http\Resources\OperationRule;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed operation_id_if
 * @property mixed operation_id_then
 * @property mixed priority
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
            'operation_id_if' => $this->operation_id_if,
            'operation_id_then' => $this->operation_id_then,
            'priority' => $this->priority
        ];
    }
}
