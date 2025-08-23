<?php

namespace App\Http\Requests\CartItem;

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
            'cart_id' => ['required', Rule::exists('carts', 'id')->whereNull('deleted_at')],
            'fabric_id' => ['required', Rule::exists('fabrics', 'id')->whereNull('deleted_at')],
            'style_id' => ['required', Rule::exists('styles', 'id')->whereNull('deleted_at')],
            'trouser_fabric_id' => ['required', Rule::exists('trouser_fabrics', 'id')->whereNull('deleted_at')],
            'button_id' => ['required', Rule::exists('buttons', 'id')->whereNull('deleted_at')],
            'price' => ['required', 'numeric'],
            'internal_lining_id' => ['required', Rule::exists('internal_linings', 'id')->whereNull('deleted_at')],
            'quantity' => ['required', 'integer', 'min:1'],
        ];

        return array_merge($this->payloadRules(), $additional_rules);
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), $this->payloadMessages());
    }
}