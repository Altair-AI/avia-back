<?php

namespace App\Http\Resources\Operation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed code
 * @property mixed verbal_name
 * @property mixed imperative_name
 * @property mixed operations
 */
class SubOperationResource extends JsonResource
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
            'name' => $this->imperative_name != "" ? $this->imperative_name : $this->verbal_name,
            'status' => null,
            'result' => null,
            'sub_operations' => []
        ];
    }
}
