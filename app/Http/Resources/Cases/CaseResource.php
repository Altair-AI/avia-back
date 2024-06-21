<?php

namespace App\Http\Resources\Cases;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed date
 * @property mixed card_number
 * @property mixed operation_time_from_start
 * @property mixed operation_time_from_last_repair
 * @property mixed malfunction_detection_stage
 * @property mixed malfunction_cause
 * @property mixed system_for_repair
 * @property mixed initial_completed_operation
 * @property mixed case_based_knowledge_base
 */
class CaseResource extends JsonResource
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
            'date' => $this->date,
            'card_number' => $this->card_number,
            'operation_time_from_start' => $this->operation_time_from_start,
            'operation_time_from_last_repair' => $this->operation_time_from_last_repair,
            'malfunction_detection_stage' => $this->malfunction_detection_stage,
            'malfunction_cause' => $this->malfunction_cause,
            'system_for_repair' => $this->system_for_repair,
            'initial_completed_operation' => $this->initial_completed_operation,
            'case_based_knowledge_base' => $this->case_based_knowledge_base
        ];
    }
}
