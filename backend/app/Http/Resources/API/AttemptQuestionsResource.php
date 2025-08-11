<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttemptQuestionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id'                    => $this->id,
            'user_id'               => $this->user_id,
            'question_id'           => $this->question_id,
            'toolbox_talk_id'       => $this->toolbox_talk_id,
            'answer'                => $this->answer,
            'is_correct'            => $this->is_correct,
            'attempt_count'         => $this->attempt_count,
            'result_data_count'     => new CalculateRightWrongAnswerResource($this) ?? null,
        ]; 
    }
}
