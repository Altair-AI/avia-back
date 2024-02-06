<?php

namespace App\Http\Resources\Operation;

use App\Http\Resources\OperationRule\OperationRuleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed code
 * @property mixed verbal_name
 * @property mixed imperative_name
 * @property mixed operation_rules
 * @property mixed hierarchy_operations
 */
class OperationHierarchyResource extends JsonResource
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
            'code' => $this->code,
            'verbal_name' => $this->verbal_name,
            'imperative_name' => $this->imperative_name,
            'operation_rules' => OperationRuleResource::collection($this->operation_rules),
            'hierarchy_operations' => OperationHierarchyResource::collection($this->hierarchy_operations)
        ];
    }
}
