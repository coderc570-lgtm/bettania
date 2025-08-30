<?php

namespace App\Http\Requests\Fabric;

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
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'filepath' => ['nullable', 'string'],
            'color' => ['required'],
            'color_code' => ['nullable'],
            'fabric_design_id' => ['required', Rule::exists('fabric_designs', 'id')->whereNull('deleted_at')],
            'fabric_season_id' => ['required', Rule::exists('fabric_seasons', 'id')->whereNull('deleted_at')],
            'fabric_material_id' => ['required', Rule::exists('fabric_materials', 'id')->whereNull('deleted_at')],
            'fabric_mill_id' => ['required', Rule::exists('fabric_mills', 'id')->whereNull('deleted_at')]
        ];

        return array_merge($this->payloadRules(), $additional_rules);
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), $this->payloadMessages());
    }
}