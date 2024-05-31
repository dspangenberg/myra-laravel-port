<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperatingInstruction extends Model
{

  protected $attributes = [
    'number' => '',
    'name' => '',
    "description" => ""
  ];


  protected $fillable = [
    'name',
    'number',
    'description'
  ];
}
