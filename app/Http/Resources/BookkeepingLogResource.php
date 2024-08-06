<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\BookkeepingLog */ class BookkeepingLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'parent_model' => $this->parent_model,
            'parent_id' => $this->parent_id,
            'text' => $this->text, //
        ];
    }
}
