<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentLinkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'receipt_id' => ['required', 'integer'],
            'transaction_id' => ['required'],
            'confidence' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
