<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\EquipmentCategory;
use App\Models\InventoryGroup;

class EquipmentCategoryCollection extends ResourceCollection
{
  public $collects = EquipmentCategoryResourceForCollection::class;

  public function toArray(Request $request): array
  {
    return [
      'data' => $this->collection,
      'groups' => InventoryGroup::orderBy('name')->get()->toArray(),
      'parent_categories' => EquipmentCategory::orderBy('name')->where('parent_id', 0)->get()->toArray()
    ];
  }
}
