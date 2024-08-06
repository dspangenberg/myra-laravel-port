<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NumberRangeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'prefix' => ['required'],
            'model' => ['required'], //
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
