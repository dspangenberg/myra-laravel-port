<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Document */ class DocumentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'org_file' => $this->org_file,
            'doc_file_name' => $this->doc_file_name,
            'issued_on' => $this->issued_on,
            'contact_id' => $this->contact_id,
            'fulltext' => $this->fulltext,
            'subject' => $this->subject,
            'size' => $this->size,
            'received_on' => $this->received_on,
        ];
    }
}
