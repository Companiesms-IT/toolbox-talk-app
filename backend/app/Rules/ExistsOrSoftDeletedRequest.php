<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\ToolboxTalk;

class ExistsOrSoftDeletedRequest implements ValidationRule
{
    protected $modelClass;
    
    public function __construct(string $model)
    {
        $this->modelClass = $model;
    }
    /**
     * Run the validation rule.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @param  Closure $fail
     * @return void
     */
    
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if the record exists and is not soft deleted
        $checkIdExistOrNot = $this->modelClass::where('id', $value)->orWhere('deleted_at', '<>', null)->exists();
        // $checkIdExistOrNot = $this->modelClass::where('id', $value)->orWhere('deleted_at', '<>', null)->exists();
        if (!$checkIdExistOrNot) {
            $fail('The selected ID is invalid.');
        } 
        // elseif ($checkIdExistOrNot->trashed()) {
        //     $fail('The selected ID has been soft deleted.');
        // }
        // if (isset($attribute) && $attribute == 'questions' && count($value) < 1) {
        //     $fail('Minimum one question is required!.');
        // }
    }
}
