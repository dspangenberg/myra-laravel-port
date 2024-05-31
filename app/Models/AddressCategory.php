<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressCategory extends Model
{
  protected $fillable = [
    'name',
    'type'
  ];
}
