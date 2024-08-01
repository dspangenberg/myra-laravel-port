<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'org_file' => ['required'],
            'doc_file_name' => ['nullable'],
            'issued_on' => ['required', 'date'],
            'contact_id' => ['required', 'integer'],
            'fulltext' => ['required'],
            'subject' => ['required'],
            'size' => ['required', 'integer'],
            'received_on' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
