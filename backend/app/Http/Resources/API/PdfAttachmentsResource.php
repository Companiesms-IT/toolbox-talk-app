<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PdfAttachmentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => isset($this['id']) ?  $this['id'] : null,
            'toolbox_talk_id'   => isset($this['toolbox_talk_id']) ? $this['toolbox_talk_id'] : null,
            'file_url'          => isset($this['file_path']) ? url($this['file_path']) : null,
            'file_name'         => isset($this['file_name']) ? $this['file_name'] : null,
            'file_status'       => isset($this['file_status']) ? $this['file_status'] : null,
            'file_state'       =>  isset($this['file_state']) ? $this['file_state']  : 'In Progress',
        ];
    }
}
