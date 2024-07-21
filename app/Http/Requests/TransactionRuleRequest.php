<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRuleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search_field' => ['required'],
            'search_value' => ['required'],
            'set_field' => ['required'],
            'set_value' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
