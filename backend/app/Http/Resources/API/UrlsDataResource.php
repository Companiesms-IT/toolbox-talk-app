<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UrlsDataResource extends JsonResource
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
            'video_url'         => isset($this['video_url']) ? $this['video_url'] : null,
            'video_status'      => isset($this['video_status']) ? $this['video_status'] : null,
            'video_state'       => isset($this['video_state']) ? $this['video_state']  : 'In Progress',
        ];
    }
}
