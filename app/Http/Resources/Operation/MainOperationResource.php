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
class MainOperationResource extends JsonResource
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
            'name' => $this->verbal_name
        ];
    }
}
