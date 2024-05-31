<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPhone extends Model
{
    protected $fillable = [
      'contact_id',
      'phone_category_id',
      'pos',
      'phone'
    ];
}
