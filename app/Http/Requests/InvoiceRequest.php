<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'contact_id' => ['required', 'integer'],
            'project_id' => ['required', 'integer'],
            'invoice_number' => ['required', 'integer'],
            'issued_on' => ['required', 'date'],
            'due_on' => ['required', 'date'],
            'dunning_block' => ['boolean'],
            'is_draft' => ['boolean'],
            'type_id' => ['required', 'integer'],
            'service_provision' => ['required'],
            'vat_id' => ['required'],
            'address' => ['required'],
            'payment_deadline_id' => ['required', 'integer'],
            'sent_at' => ['required', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
