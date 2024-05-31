<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EquipmentCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
          'id' => $this->id,
          'parent_id' => $this->parent_id,
          'name' => $this->name,
          'parent' => $this->parent,
          'inventory_groups' => $this->inventory_groups()->allRelatedIds()
        ];
    }
}
