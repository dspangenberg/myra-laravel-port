<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeCategory extends Model
{
    protected $fillable = [
      'name',
      'short_name',
      'pos',
      'is_default',
      'hourly'
    ];
}
