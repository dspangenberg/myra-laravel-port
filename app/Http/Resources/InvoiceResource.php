<?php

namespace App\Http\Resources;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Invoice */ class InvoiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'contact_id' => $this->contact_id,
            'contact' => ContactResource::make($this->contact),
            'project_id' => $this->project_id,
            'project' => ProjectResource::make($this->project),
            'invoice_number' => $this->invoice_number,
            'issued_on' => $this->issued_on,
            'due_on' => $this->due_on,
            'dunning_block' => $this->dunning_block,
            'is_draft' => $this->is_draft,
            'type_id' => $this->type_id,
            'filename' => $this->filename,
            'service_provision' => $this->service_provision,
            'vat_id' => $this->vat_id,
            'address' => $this->address,
            'payment_deadline_id' => $this->payment_deadline_id,
            'sent_at' => $this->sent_at,
            'formated_invoice_number' => $this->formated_invoice_number,
            'lines_sum_amount' => $this->lines_sum_amount,
            'lines_sum_tax' => $this->lines_sum_tax,
            'payments_sum_amount' => $this->payments_sum_amount,
        ];
    }
}
