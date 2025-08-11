<?php

namespace App\Http\Requests\API;
use App\Models\ToolboxTalk;
use App\Rules\ExistsOrSoftDeletedRequest;

use Illuminate\Foundation\Http\FormRequest;

class CheckVideoPdfStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'toolbox_talk_id'   => ['required', 'integer', new ExistsOrSoftDeletedRequest(ToolboxTalk::class)],
            'video_id'          => 'required_without:file_id|exists:resource_video_links,id',
            'file_id'           => 'required_without:video_id|exists:media_files,id',
            'type'              => 'required|in:Video,Pdf',
            'status'            => 'required|in:1,2'
        ];
    }
}
