<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTimeRequest extends FormRequest
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
            'begin_at' => 'required',
            'end_at' => 'nullable|after:begin_at',
            'project_id' => 'required',
            'time_category_id' => 'required',
            'user_id' => 'required',
            'is_billable' => 'boolean',
            'is_locked' => 'boolean',
            'note' => 'nullable',
        ];
    }
}
