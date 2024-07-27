<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\PaymentLink */ class PaymentLinkResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'receipt_id' => $this->receipt_id,
            'transaction_id' => $this->transaction_id,
            'confidence' => $this->confidence,
        ];
    }
}
