<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\AttemptQuestion;
use App\Models\Question;
class CalculateCorrectAnswersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       
        $userId = $this->user_id;
        $toolboxId = $this->toolbox_talk_id;
        $lastAttempt = $this->attempt_count;
        $correctAnswersCount = AttemptQuestion::where('user_id', $userId)
            ->where('toolbox_talk_id', $toolboxId)
            ->where('is_correct', '1')
            ->where('attempt_count', $lastAttempt) 
            ->count();

        //$totalQuestionsCount = Question::where('toolbox_talk_id', $toolboxId)->count();
        $totalQuestionsCount  =  AttemptQuestion::where('user_id', $userId)
            ->where('toolbox_talk_id', $toolboxId)
            ->where('attempt_count', $lastAttempt) 
            ->count();
        
        return [
            'result' => $totalQuestionsCount > 0 ? "{$correctAnswersCount}/{$totalQuestionsCount}" : "0/0",
        ];
    }
}
