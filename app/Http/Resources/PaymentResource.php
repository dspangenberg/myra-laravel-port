<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Payment */ class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'receipt_id' => $this->receipt_id,
            'transaction_id' => $this->transaction_id,
            'amount' => $this->amount,
            'bookkeeping_account_id' => $this->bookkeeping_account_id,
            'split_id' => $this->split_id,
        ];
    }
}
