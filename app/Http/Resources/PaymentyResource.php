<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Paymenty */ class PaymentyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'transaction_id' => $this->transaction_id,
            'amount' => $this->amount,
            'is_private' => $this->is_private,
            'issued_on' => $this->issued_on,
            'is_confirmed' => $this->is_confirmed,
            'is_booked' => $this->is_booked,
        ];
    }
}
