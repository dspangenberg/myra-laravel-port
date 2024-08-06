<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookkeepingLog extends Model
{
    protected $fillable = [
        'parent_model',
        'parent_id',
        'text',
    ];
}
