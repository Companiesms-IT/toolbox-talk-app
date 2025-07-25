<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class ToolBoxDetailsResource extends JsonResource
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
            'id'                               => $this->id,
            'title'                            => $this->title,
            'number_of_questions_to_ask'       => $this->number_of_questions_to_ask,
            'number_of_correct_answer_to_pass' => $this->number_of_correct_answer_to_pass,
            'description'                      => $this->description,
            'user_id'                          => $this->user_id,
            'is_library'                       => $this->is_library,
            'due_date'                         => $this->due_date,
            'deleted_at'                       => $this->deleted_at,
            'status'                           => $this->status,
            'created_at'                       => $this->created_at,
            'updated_at'                       => $this->updated_at,
            'questions'                        => ToolBoxQuestionsResource::collection($this->questions),
            'video_url'                        => UrlsDataResource::collection($this->resourceUrlData),
            'file_data'                        => PdfAttachmentsResource::collection($this->attachmentsPdfData),
            'assigned_users'                   => ToolBoxAssignedUsersResource::collection($this->getAssignedUsers),
            'created_by_user'                  => new ToolBoxCreatedByUserResource($this->getCreatedByUser),
        ];
    }
}
