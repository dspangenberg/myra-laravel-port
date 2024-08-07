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
            'contact_id' => $this->contact_id,
            'contact' => new ContactResource($this->contact),
            'booked_on' => $this->booked_on,
            'comment' => $this->comment,
            'purpose' => $this->purpose,
            'account_number' => $this->account_number,
            'booking_text' => $this->booking_text,
            'currency' => $this->currency,
            'bank_code' => $this->bank_code,
            'amount' => $this->amount,
            'is_transit' => $this->is_transit,
            'booking' => new BookkeepingBookingResource($this->booking),
            'is_private' => $this->is_private,
            'amount_in_foreign_currency' => $this->amount_in_foreign_currency,
            'name' => $this->name,
            'bookkepping_text' => $this->bookkepping_text,
            'document_number' => $this->document_number,
        ];
    }
}
