<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $fillable = [
      'project_id',
      'time_category_id',
      'subproject_id',
      'task_id',
      'user_id',
      'invoice_id',
      'note',
      'begin_at',
      'end_at',
      'is_locked',
      'is_billable',
      'is_timer',
      'minutes',
      'dob',
      'ping_at',
      'note',
      'avatar'
    ];
}
