<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetQuestionOptionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                               => $this->id,
            'title'                            => $this->title,
            'number_of_questions_to_ask'       => $this->number_of_questions_to_ask,
            'number_of_correct_answer_to_pass' => $this->number_of_correct_answer_to_pass,
            'description'                      => $this->description,
            'user_id'                          => $this->user_id,
            'is_library'                       => $this->is_library,
            'questions'                        => ToolBoxOnlyQuestionOptionsResource::collection($this->questionsOptions),
        ];
    }
}
