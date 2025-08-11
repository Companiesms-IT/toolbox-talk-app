<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ToolBoxOnlyQuestionOptionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => isset($this['id']) ? $this['id'] : null,
            'name'             => isset($this['name']) ? $this['name'] : null,
            'options'          => isset($this->options) ? ToolBoxOptionsResource::collection($this->options) : [],
        ];
    }
}
