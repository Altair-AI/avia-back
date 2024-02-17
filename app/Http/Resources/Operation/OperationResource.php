<?php

namespace App\Http\Resources\Operation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed verbal_name
 * @property mixed imperative_name
 */
class OperationResource extends JsonResource
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
            'name' => $this->imperative_name != "" ? $this->imperative_name : $this->verbal_name
        ];
    }
}
