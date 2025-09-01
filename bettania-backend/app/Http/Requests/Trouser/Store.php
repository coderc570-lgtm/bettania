<?php

namespace App\Http\Requests\Trouser;

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
            'waist_band_id' => ['required', Rule::exists('waist_bands', 'id')->whereNull('deleted_at')],
            'pleat_id' => ['required', Rule::exists('pleats', 'id')->whereNull('deleted_at')]
        ];

        return array_merge($this->payloadRules(), $additional_rules);
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), $this->payloadMessages());
    }
}