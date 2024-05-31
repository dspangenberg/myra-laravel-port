<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\BusinessSegment;

class FilingCollection extends ResourceCollection
{
  public function toArray(Request $request): array
  {
    return [
      'data' => $this->collection,
      'segments' => BusinessSegment::orderBy('name')->get()->toArray()
    ];
  }
}

