<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ExistsOrSoftDeletedRequest;

class CreateToolboxTalkRequest extends FormRequest
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
 
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255|unique:toolbox_talks,title,NULL,id',
        ];
     
        return $rules;
    }
    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     */
    protected function withValidator($validator)
    {
        
         $validator->after(function ($validator) {
            if ($this->isLibrary == 2 || $this->isLibrary == 3) {
                if (empty($this->selectAll) && empty($this->input('selectDept', [])) && empty($this->input('selectRole', [])) && empty($this->input('selectUser', []))) {
                    // $validator->errors()->add('minimum_select_one', 'You need to choose at least one role, department or user.');
                    return;
                }
            }
        });
    }
    public function messages()
    {
        return [
            'title.required' => 'The title is required.',
        ];
    }
}
