<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookkeepingLogRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'parent_model' => ['required'],
            'parent_id' => ['required'],
            'text' => ['required'], //
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
