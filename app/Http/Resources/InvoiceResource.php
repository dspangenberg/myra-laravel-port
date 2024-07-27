<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Invoice */ class InvoiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'contact_id' => $this->contact_id,
            'project_id' => $this->project_id,
            'invoice_number' => $this->invoice_number,
            'issued_on' => $this->issued_on,
            'due_on' => $this->due_on,
            'dunning_block' => $this->dunning_block,
            'is_draft' => $this->is_draft,
            'type_id' => $this->type_id,
            'service_provision' => $this->service_provision,
            'vat_id' => $this->vat_id,
            'address' => $this->address,
            'payment_deadline_id' => $this->payment_deadline_id,
            'sent_at' => $this->sent_at,
        ];
    }
}
