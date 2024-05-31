<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $fillable = [
      'name',
      'correspondence_salutation_male',
      'correspondence_salutation_female',
      'correspondence_salutation_other'
    ];
}
