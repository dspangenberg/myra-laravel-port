<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSegment extends Model
{
    use HasFactory;
    protected $attributes = [
      'name' => ''
    ];

    protected $fillable = [
      'name'
    ];
}
