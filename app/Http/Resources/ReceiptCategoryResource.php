<?php

namespace App\Http\Resources;

use App\Models\ReceiptCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ReceiptCategory
 */
class ReceiptCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'receipts_ref' => $this->receipts_ref,
            'name' => $this->name
        ];
    }
}
