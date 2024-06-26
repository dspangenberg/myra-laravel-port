<?php

namespace App\Http\Resources;

use App\Models\Salutation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Salutation
 */
class SalutationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->first_name,
            'gender' => $this->gender,
            'is_hidden' => $this->is_hidden,
        ];
    }
}
