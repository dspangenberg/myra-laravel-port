<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'receipt_id' => ['required', 'integer'],
            'transaction_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric'],
            'bookkeeping_account_id' => ['required', 'integer'],
            'split_id' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
