<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\PhoneCategory;
use App\Models\InventoryGroup;

class EquipmentCategoryCollection extends ResourceCollection
{
  public $collects = EquipmentCategoryResourceForCollection::class;

  public function toArray(Request $request): array
  {
    return [
      'data' => $this->collection,
      'groups' => InventoryGroup::orderBy('name')->get()->toArray(),
      'parent_categories' => PhoneCategory::orderBy('name')->where('parent_id', 0)->get()->toArray()
    ];
  }
}
