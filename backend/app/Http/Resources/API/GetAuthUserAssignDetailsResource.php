<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetAuthUserAssignDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $time = null;
        $date = null;
        if ($this->date_time) {
            $dateTime = $this->date_time;
            $time = date('H:i:s', strtotime($dateTime));
            $date = date('Y-m-d', strtotime($dateTime));
        }
        return [
            'id'               => $this->id,
            'title'            => $this->getToolboxTalk->title,
            'description'      => $this->getToolboxTalk->description,
            'user_id'          => $this->getToolboxTalk->user_id,
            'is_library'       => $this->getToolboxTalk->is_library,
            'due_date'         => $this->getToolboxTalk->due_date,
            'deleted_at'       => $this->getToolboxTalk->deleted_at,
            'status'           => $this->getToolboxTalk->status,
            'created_at'       => $this->getToolboxTalk->created_at,
            'updated_at'       => $this->getToolboxTalk->updated_at,
            'name'             => $this->user_name,
            'status'           => $this->status,
            'attempt'          => $this->attempt_count,
            'time'             => $time,
            'date'             => $date,
            'result'           => new CalculateCorrectAnswersResource($this),
            'questions'        => ToolBoxQuestionsResource::collection($this->getToolboxTalk->questions),
            'video_url'        => UrlsDataResource::collection($this->getToolboxTalk->resourceUrlData),
            'file_data'        => PdfAttachmentsResource::collection($this->getToolboxTalk->attachmentsPdfData),
        ];
    }
}
