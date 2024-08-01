<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\DocumentFolder */ class DocumentFolderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'is_grouped_by_contact' => $this->is_grouped_by_contact,
            'is_grouped_by_year' => $this->is_grouped_by_year,
            'is_grouped_by_month' => $this->is_grouped_by_month,
        ];
    }
}
