<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ExistsOrSoftDeletedRequest;
use App\Models\ToolboxTalk;

class UpdateContentToolboxRequest extends FormRequest
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
            'title'             => 'required_without:description',
            'description'       => 'required_without:title',
        ];
    }
}
