<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empowerment extends Model
{
    use HasFactory;

    protected $attributes = [
      'name' => '',
      'abbreviation' => ''
    ];

    protected $fillable = [
      'name',
      'abbreviation'
    ];
}
