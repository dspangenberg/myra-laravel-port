<?php

namespace App\Http\Resources;

use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin Receipt
 */
class ReceiptResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'receipts_ref' => $this->receipts_ref,
            'reference' => $this->reference,
            'receipt_category_id' => $this->receipt_category_id,
            'contact_id' => $this->contact_id,
            'issued_on' => $this->issued_on,
            'tax_rate' => $this->tax_rate,
            'amount' => $this->amount,
            'currency_code' => $this->currency_code,
            'exchange_rate' => $this->exchange_rate,
            'gross' => $this->gross,
            'net' => $this->net,
            'tax' => $this->tax,
            'tax_code_number' => $this->tax_code_number,
            'title' => $this->title,
            'pdf_file' => $this->pdf_file,
            'export_file_name' => $this->export_file_name,
            'document_number' => $this->document_number,
            'real_document_number' => $this->real_document_number,
            'type' => $this->type,
            'year' => $this->year,
            'text' => $this->text,
            'amount_to_pay' => $this->amount_to_pay,
            'text_md5' => $this->text_md5,
            'contact' => new ContactResource($this->whenLoaded('contact')),
            'category' => new ReceiptCategoryResource($this->whenLoaded('category')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
