<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $fillable = [
      'name',
      'invoice_text',
      'value',
      'needs_vat_id',
      'is_default'
    ];
}
