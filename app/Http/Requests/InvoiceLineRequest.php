<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceLineRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'invoice_id' => ['required', 'integer'],
            'quantity' => ['required', 'numeric'],
            'unit' => ['required'],
            'text' => ['required'],
            'price' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
            'tax' => ['required', 'numeric'],
            'tax_id' => ['required', 'integer'],
            'pos' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
