<?php

namespace App\Http\Requests\Jacket;

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
            'closure_id' => ['required', Rule::exists('closures', 'id')->whereNull('deleted_at')],
            'button_id' => ['required', Rule::exists('buttons', 'id')->whereNull('deleted_at')],
            'pocket_id' => ['required', Rule::exists('pockets', 'id')->whereNull('deleted_at')],
            'fabric_id' => ['required', Rule::exists('fabrics', 'id')->whereNull('deleted_at')],
            'lapel_id' => ['required', Rule::exists('lapels', 'id')->whereNull('deleted_at')]
        ];

        return array_merge($this->payloadRules(), $additional_rules);
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), $this->payloadMessages());
    }
}