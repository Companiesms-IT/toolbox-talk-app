<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ExistsOrSoftDeletedRequest;
use App\Models\ToolboxTalk;
use App\Models\MediaFile;

class DeleteUpdateCmsLibraryRequest extends FormRequest
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
            'toolbox_talk_id'   => ['required', new ExistsOrSoftDeletedRequest(ToolboxTalk::class)],
            'toolbox_talk_id.*' => ['exists:toolbox_talks,id'],
        ];
    }
}
