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
        // $parts = explode('/', $this['file_name']);
        // // dd($parts, "ds;fkdsl;f");
        // if (count($parts) > 2) {
        //     $fileName = implode('/', array_slice($parts, 2));
        // } else {
        //     $fileName = null;
        // }    
        return [
            'id'                => $this['id'],
            'toolbox_talk_id'   => $this['toolbox_talk_id'],
            'file_url'          => url($this['file_path']),
            'file_name'         => $this['file_name'],
        ];
    }
}
