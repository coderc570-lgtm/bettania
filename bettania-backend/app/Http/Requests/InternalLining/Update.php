<?php

namespace App\Http\Requests\InternalLining;

use App\Traits\PayloadRuleTrait;
use Illuminate\Foundation\Http\FormRequest;
use Bouncer;

class Update extends FormRequest
{
    use PayloadRuleTrait;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $additional_rules = [
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'filepath' => ['nullable', 'string'],
            'upper_filepath' => ['nullable', 'string'],
            'lower_filepath' => ['nullable', 'string']
        ];

        return array_merge($this->payloadRules(), $additional_rules);
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), $this->payloadMessages());
    }
}