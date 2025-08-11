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
            'id'               => isset($this->id) ? $this->id : null,
            'title'            => isset($this->getToolboxTalk) ? $this->getToolboxTalk->title : null,
            'description'      => isset($this->getToolboxTalk) ? $this->getToolboxTalk->description : null,
            'user_id'          => isset($this->getToolboxTalk) ? $this->getToolboxTalk->user_id : null,
            'is_library'       => isset($this->getToolboxTalk) ? $this->getToolboxTalk->is_library : null,
            'due_date'         => isset($this->getToolboxTalk) ? $this->getToolboxTalk->due_date : null,
            'deleted_at'       => isset($this->getToolboxTalk) ? $this->getToolboxTalk->deleted_at : null,
            'status'           => isset($this->getToolboxTalk) ? $this->getToolboxTalk->status : null,
            'created_at'       => isset($this->getToolboxTalk) ? $this->getToolboxTalk->created_at : null,
            'updated_at'       => isset($this->getToolboxTalk) ? $this->getToolboxTalk->updated_at : null,
            'created_by'       => isset($this->getToolboxTalk->getCreatedByUser->name) ? $this->getToolboxTalk->getCreatedByUser->name : null,
            'name'             => isset($this->user_name) ?  $this->user_name : null,
            'status'           => isset($this->status) ? $this->status : null,
            'attempt'          => isset($this->attempt_count) ? $this->attempt_count : null,
            'time'             => $time ?? null,
            'date'             => $date ?? null,
            'result_data'      => isset($this->result) && !empty($this->result) ? $this->result : null,
            'result'           => isset($this) ? new CalculateCorrectAnswersResource($this) : null,
            'questions'        => isset($this->getToolboxTalk) ? ToolBoxQuestionsResource::collection($this->getToolboxTalk->questions) : null,
            'video_url'        => isset($this->getToolboxTalk) ? UrlsDataResource::collection($this->getToolboxTalk->resourceUrlData) : null,
            'file_data'        => isset($this->getToolboxTalk) ? PdfAttachmentsResource::collection($this->getToolboxTalk->attachmentsPdfData) : null,
        ];
    }
}
