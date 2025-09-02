<?php

namespace App\Http\Requests\VShape;

use App\Traits\PayloadRuleTrait;
use Illuminate\Foundation\Http\FormRequest;
use Bouncer;

class Store extends FormRequest
{
    use PayloadRuleTrait;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $additional_rules = [
            'string' => ['required'],
            'description' => ['nullable'],
            'filepath' => ['nullable'],
            'price' => ['nullable', 'numeric']
        ];

        return array_merge($this->payloadRules(), $additional_rules);
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), $this->payloadMessages());
    }
}