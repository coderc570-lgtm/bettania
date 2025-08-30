<?php

namespace App\Http\Requests\Closure;

use App\Traits\PayloadRuleTrait;
use Illuminate\Foundation\Http\FormRequest;
use Bouncer;
use Illuminate\Validation\Rule;

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
            'title' => ['required'],
            'description' => ['required'],
            'filepath' => ['required'],
            'custom_made_id' => ['required', Rule::exists('custom_mades', 'id')->whereNull('deleted_at')],
            'price' => ['nullable', 'numeric']
        ];

        return array_merge($this->payloadRules(), $additional_rules);
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), $this->payloadMessages());
    }
}