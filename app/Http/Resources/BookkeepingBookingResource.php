<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\BookkeepingBooking */
class BookkeepingBookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'transaction_id' => $this->transaction_id,
            'receipt_id' => $this->receipt_id,
            'payment_id' => $this->payment_id,
            'account_id_credit' => $this->account_id_credit,
            'account_credit' => $this->account_credit,
            'account_id_debit' => $this->account_id_debit,
            'account_debit' => $this->account_debit,
            'amount' => $this->amount,
            'date' => $this->date,
            'tax_id' => $this->tax_id,
            'tax' => $this->tax,
            'is_split' => $this->is_split,
            'split_id' => $this->split_id,
            'booking_text' => $this->booking_text,
            'document_number' => $this->document_number,
            'note' => $this->note,
            'tax_credit' => $this->tax_credit,
            'tax_debit' => $this->tax_debit,
            'is_locked' => $this->is_locked,
        ];
    }
}
