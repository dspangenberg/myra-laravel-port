<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'iban' => ['required'],
            'bic' => ['required'],
            'bank_code' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
