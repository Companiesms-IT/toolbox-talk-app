<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class ToolBoxQuestionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'               => isset($this['id']) ? $this['id'] : null,
            'name'             => isset($this['name']) ? $this['name'] : null,
            'options'          => isset($this->options) ? ToolBoxOptionsResource::collection($this->options) : [],
            'correct_answer'   => isset($this->correctAnswer) ? ToolBoxOptionsResource::collection($this->correctAnswer) : [],
        ];
    }
}
