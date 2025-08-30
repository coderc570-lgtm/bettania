<?php

namespace App\Http\Requests\FabricMaterial;

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
            'head_fabric_material_id' => ['required', Rule::exists('fabric_materials', 'id')->whereNull('deleted_at')]
        ];

        return array_merge($this->payloadRules(), $additional_rules);
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), $this->payloadMessages());
    }
}