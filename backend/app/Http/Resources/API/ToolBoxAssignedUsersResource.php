<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class ToolBoxAssignedUsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $time = null;
        $date = null;
        if ($this->date_time) {
            $dateTime = $this->date_time;
            $time = date('H:i:s', strtotime($dateTime));
            $date = date('Y-m-d', strtotime($dateTime));
        }
        return [
            'id'         => $this->id,
            'name'       => $this->user_name,
            'status'     => $this->status == 2 ? 'Completed' : "",
            'attempt'    => $this->attempt_count,
            'time'       => $time,
            'date'       => $date,
            'result'     => new CalculateCorrectAnswersResource($this),
        ];
    }
}
