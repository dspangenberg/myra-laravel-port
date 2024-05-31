<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BusinessSegment;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InventoryGroup extends Model
{
    use HasFactory;

    protected $attributes = [
      'name' => '',
      'inventory_number_prefix' => '',
      'inventory_current_number' => 0,
      'business_segment_id' => 0,
    ];


    protected $fillable = [
      'name',
      'inventory_number_prefix',
      'inventory_current_number',
      'business_segment_id'
    ];

    public function segment(): HasOne
    {
        return $this->hasOne(BusinessSegment::class, 'id', 'business_segment_id');
    }
}

