<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMail extends Model
{
    protected $fillable = [
      'contact_id',
      'email_category_id',
      'pos',
      'email'
    ];
}
