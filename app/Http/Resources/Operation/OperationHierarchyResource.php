<?php

namespace App\Http\Resources\Operation;

use App\Http\Resources\OperationRule\OperationRuleResource;
use App\Models\Operation;
use App\Models\OperationRule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed code
 * @property mixed verbal_name
 * @property mixed imperative_name
 * @property mixed operation_rules
 * @property mixed hierarchy_operations
 * @property mixed extra
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
        // Поиск правил определения работ для текущей работы в определенном контексте работы РУН
        $operation_rules = OperationRule::where('operation_id_if', $this->id)
            ->where('context', Operation::whereId($this->extra->parent_operation_id)->first()->code)
            ->get();
        // Добавление дополнительного поля с id работы РУН
        foreach ($this->hierarchy_operations as $sub_operation)
            $sub_operation->extra = (object) $this->extra;

        return [
            'id' => $this->id,
            'code' => $this->code,
            'verbal_name' => $this->verbal_name,
            'imperative_name' => $this->imperative_name,
            'operation_rules' => OperationRuleResource::collection($operation_rules),
            'hierarchy_operations' => OperationHierarchyResource::collection($this->hierarchy_operations)
        ];
    }
}
