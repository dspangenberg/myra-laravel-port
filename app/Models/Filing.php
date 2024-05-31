<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Filing extends Model
{
    use HasFactory;

    protected $attributes = [
      'name' => '',
      'business_segment_id' => ''
    ];


    protected $fillable = [
      'name',
      'business_segment_id'
    ];

    public function segment(): HasOne
    {
        return $this->hasOne(BusinessSegment::class, 'id', 'business_segment_id');
    }
}
