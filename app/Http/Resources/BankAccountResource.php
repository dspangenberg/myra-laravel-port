<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\BankAccount */
class BankAccountResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'name' => $this->name,
            'iban' => $this->iban,
            'bic' => $this->bic,
            'bank_code' => $this->bank_code,
        ];
    }
}
