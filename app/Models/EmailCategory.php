<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailCategory extends Model
{
    protected $fillable = [
      'name',
      'days',
      'is_immediately',
      'is_default',
    ];
}
