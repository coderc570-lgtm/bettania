<?php

namespace App\Http\Requests\Cart;

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
            'cart_items' => ['required', 'array'],
            'cart_items.*.fabric_id' => ['required', Rule::exists('fabrics', 'id')->whereNull('deleted_at')],
            'cart_items.*.style_id' => ['required', Rule::exists('styles', 'id')->whereNull('deleted_at')],
            'cart_items.*.trouser_fabric_id' => ['required', Rule::exists('trouser_fabrics', 'id')->whereNull('deleted_at')],
            'cart_items.*.button_id' => ['required', Rule::exists('buttons', 'id')->whereNull('deleted_at')],
            'cart_items.*.internal_lining_id' => ['required', Rule::exists('internal_linings', 'id')->whereNull('deleted_at')],
            'cart_items.*.lapel_id' => ['required', Rule::exists('lapels', 'id')->whereNull('deleted_at')],
            'cart_items.*.price' => ['required', 'numeric'],
            'cart_items.*.quantity' => ['required', 'integer'],
        ];

        return array_merge($this->payloadRules(), $additional_rules);
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), $this->payloadMessages());
    }
}