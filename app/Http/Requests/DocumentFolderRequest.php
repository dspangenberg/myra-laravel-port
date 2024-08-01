<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentFolderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => ['required', 'integer'],
            'name' => ['required'],
            'is_grouped_by_contact' => ['boolean'],
            'is_grouped_by_year' => ['boolean'],
            'is_grouped_by_month' => ['boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
