<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'transaction_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric'],
            'is_private' => ['boolean'],
            'issued_on' => ['required', 'date'],
            'is_confirmed' => ['boolean'],
            'is_booked' => ['boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
