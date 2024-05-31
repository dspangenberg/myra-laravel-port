<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InventoryGroup;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class EquipmentCategory extends Model
{
    use HasFactory;

    protected $attributes = [
      'name' => '',
      'parent_id' => 0
    ];


    protected $fillable = [
      'name',
      'parent_id'
    ];

    public function parent(): HasOne
    {
        return $this->hasOne(EquipmentCategory::class, 'id', 'parent_id');
    }

    public function inventory_groups(): BelongsToMany
    {
        return $this->belongsToMany(InventoryGroup::class);
    }
}
