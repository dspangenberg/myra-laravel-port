<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\TransactionRule */
class TransactionRuleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'search_field' => $this->search_field,
            'search_value' => $this->search_value,
            'set_field' => $this->set_field,
            'set_value' => $this->set_value,
        ];
    }
}
