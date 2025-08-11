<?php

namespace App\Http\Resources\API;

use App\Models\AttemptQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CalculateRightWrongAnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $totalQuestionsCount = 0;
        $resultDataCorrect = 0;
        $resultDataWrong = 0;
        $userId      = $this->user_id;
        $toolboxId   = $this->toolbox_talk_id;
        $lastAttempt = $this->attempt_count;
        if (!empty($this->user_id) && !empty($this->toolbox_talk_id) && !empty($this->attempt_count)) {
            $correctAnswersCount = AttemptQuestion::where('user_id', $userId)->where('toolbox_talk_id', $toolboxId)->where('is_correct', '1')->where('attempt_count', $lastAttempt)->count();
            $totalQuestionsCount  =  AttemptQuestion::where('user_id', $userId)->where('toolbox_talk_id', $toolboxId)->where('attempt_count', $lastAttempt)->count();
            // $resultDataCorrect = "{$correctAnswersCount}/{$totalQuestionsCount}";
        } 
        return [
            'total_questions'        => $totalQuestionsCount ?? 0,
            'number_of_attempted'    => $totalQuestionsCount ?? 0,
            'number_of_passed'       => $correctAnswersCount ?? 0,
        ];
    }
}
