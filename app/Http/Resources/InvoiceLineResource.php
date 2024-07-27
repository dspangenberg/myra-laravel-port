<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\InvoiceLine */ class InvoiceLineResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'invoice_id' => $this->invoice_id,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'text' => $this->text,
            'price' => $this->price,
            'amount' => $this->amount,
            'tax' => $this->tax,
            'tax_id' => $this->tax_id,
            'pos' => $this->pos,
        ];
    }
}
