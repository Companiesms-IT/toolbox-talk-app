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
        $totalQuestionsCount = 0;
        $resultDataCorrect = 0;
        $resultDataWrong = 0;
       
        $userId      = $this->user_id;
        $toolboxId   = $this->toolbox_talk_id;
        $lastAttempt = $this->attempt_count;
        if (!empty($this->user_id) && !empty($this->toolbox_talk_id) && !empty($this->attempt_count)) {
            $correctAnswersCount = AttemptQuestion::where('user_id', $userId)->where('toolbox_talk_id', $toolboxId)->where('is_correct', '1')->where('attempt_count', $lastAttempt)->count();

            $totalQuestionsCount  =  AttemptQuestion::where('user_id', $userId)->where('toolbox_talk_id', $toolboxId)->where('attempt_count', $lastAttempt)->count();

            $resultDataCorrect = "{$correctAnswersCount}/{$totalQuestionsCount}";
        } else {
            $resultDataWrong = "0/0";
        }

        return [
            'result' => $totalQuestionsCount > 0 ? $resultDataCorrect : $resultDataWrong,
        ];
    }
}
