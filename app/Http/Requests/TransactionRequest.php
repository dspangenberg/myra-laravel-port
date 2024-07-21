<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'mm_ref' => ['required'],
            'valued_on' => ['required', 'date'],
            'booked_on' => ['nullable', 'date'],
            'comment' => ['nullable'],
            'currency' => ['required'],
            'bank_code' => ['required'],
            'name' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
