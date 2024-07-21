<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookkeepingBookingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'transaction_id' => ['required', 'integer'],
            'receipt_id' => ['required', 'integer'],
            'payment_id' => ['required', 'integer'],
            'account_id_credit' => ['required', 'integer'],
            'account_id_debit' => ['required'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'tax_id' => ['required', 'integer'],
            'is_split' => ['boolean'],
            'split_id' => ['required', 'integer'],
            'booking_text' => ['required'],
            'document_number' => ['required'],
            'note' => ['required'],
            'tax_credit' => ['required', 'numeric'],
            'tax_debit' => ['required', 'numeric'],
            'is_locked' => ['boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
