<?php

namespace App\Http\Requests\Closure;

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
            'title' => ['required'],
            'description' => ['required'],
            'filepath' => ['required'],
            'custom_made_id' => ['nullable', Rule::exists('custom_mades', 'id')->whereNull('deleted_at')],
            'price' => ['nullable', 'numeric'],
            'closure_type_id' => ['required', Rule::exists('closure_types', 'id')->whereNull('deleted_at')]
        ];

        return array_merge($this->payloadRules(), $additional_rules);
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), $this->payloadMessages());
    }
}