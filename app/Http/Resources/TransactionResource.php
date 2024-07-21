<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Transaction */
class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'mm_ref' => $this->mm_ref,
            'valued_on' => $this->valued_on,
            'booked_on' => $this->booked_on,
            'comment' => $this->comment,
            'currency' => $this->currency,
            'bank_code' => $this->bank_code,
            'name' => $this->name,
        ];
    }
}
