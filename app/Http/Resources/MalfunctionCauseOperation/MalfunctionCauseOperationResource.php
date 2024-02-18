<?php

namespace App\Http\Resources\MalfunctionCauseOperation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed malfunction_cause
 * @property mixed source_priority
 */
class MalfunctionCauseOperationResource extends JsonResource
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
            'name' => $this->malfunction_cause->name,
            'priority' => $this->source_priority,
        ];
    }
}
