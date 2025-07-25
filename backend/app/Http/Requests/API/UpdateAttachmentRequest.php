<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ExistsOrSoftDeletedRequest;
use App\Models\ToolboxTalk;
use App\Models\MediaFile;

class UpdateAttachmentRequest extends FormRequest
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
            'toolbox_talk_id'      => ['required', 'integer', new ExistsOrSoftDeletedRequest(ToolboxTalk::class)],
            // 'attachment_id'        => ['required', 'integer', new ExistsOrSoftDeletedRequest(MediaFile::class)],
            'resource_url'         => ['required_without:pdf_file'],
           'pdf_file'             => 'required_without:resource_url|array|max:6144',
        'pdf_file.*'           => 'file|mimes:pdf|max:6144', // Validate each PDF file in the array
        ];
    }
}
