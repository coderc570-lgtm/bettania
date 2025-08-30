<?php

namespace App\Http\Requests\Style;

use App\Traits\PayloadRuleTrait;
use Illuminate\Foundation\Http\FormRequest;
use Bouncer;
use Illuminate\Validation\Rule;

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
            'description' => ['required'],
            'custom_made_id' => ['nullable', Rule::exists('custom_mades', 'id')->whereNull('deleted_at')],
        ];

        return array_merge($this->payloadRules(), $additional_rules);
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), $this->payloadMessages());
    }
}