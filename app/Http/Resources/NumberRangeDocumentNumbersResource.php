<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\NumberRangeDocumentNumbers */ class NumberRangeDocumentNumbersResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'number_range_id' => $this->number_range_id,
            'year' => $this->year,
            'document_number' => $this->document_number, //
        ];
    }
}
