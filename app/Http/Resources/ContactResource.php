<?php

namespace App\Http\Resources;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Contact
 */
class ContactResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company_id' => $this->company_id,
            'company' => $this->company,
            'name' => $this->name,
            'first_name' => $this->first_name,
            'full_name' => $this->full_name,
            'reverse_full_name' => $this->reverse_full_name,
            'initials' => $this->initials,
            'title' => $this->title,
        ];
    }
}
