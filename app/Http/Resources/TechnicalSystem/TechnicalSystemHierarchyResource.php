<?php

namespace App\Http\Resources\TechnicalSystem;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed code
 * @property mixed name
 * @property mixed description
 * @property mixed parent_technical_system_id
 * @property mixed technical_subsystems
 * @property mixed documents
 * @property mixed rule_based_knowledge_bases
 */
class TechnicalSystemHierarchyResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'parent_technical_system_id' => $this->parent_technical_system_id,
            'technical_subsystems' => $this->technical_subsystems,
            'documents' => $this->documents,
            'rule_based_knowledge_bases' => $this->rule_based_knowledge_bases
        ];
    }
}
