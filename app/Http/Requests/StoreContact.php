<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreContact extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'first_name' => 'nullable',
            'short_name' => 'nullable',
            'company_id' => 'nullable',
            'salutation_id' => 'nullable',
            'title' => 'nullable',
            'is_org' => 'nullable|boolean',
            'is_debtor' => 'nullable|boolean',
            'is_creditor' => 'nullable|boolean',
            'department' => 'nullable',
            'position' => 'nullable',
            'outturn_account_id' => 'integer',
            'is_primary' => 'nullable|boolean',
            'ref' => 'nullable',
            'debtor_number' => 'nullable',
            'has_dunning_block' => 'nullable|boolean',
            'creditor_number' => 'nullable',
            'is_archived' => 'nullable|boolean',
            'archived_reason' => 'nullable',
            'payment_deadline_id' => 'nullable',
            'tax_id' => 'nullable',
            'vat_id' => 'nullable',
            'register_number' => 'nullable',
            'register_court' => 'nullable',
            'website' => 'nullable',
            'dob' => 'nullable',
            'tax_number' => 'nullable',
            'mails' => 'nullable',
        ];
    }
}
