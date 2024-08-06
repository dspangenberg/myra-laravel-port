<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NumberRangeDocumentNumbersRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'number_range_id' => ['required', 'integer'],
            'year' => ['required', 'integer'],
            'document_number' => ['required', 'integer'], //
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
