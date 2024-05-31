<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
      'name',
      'owner_contact_id',
      'lead_user_id',
      'manager_contact_id',
      'invoice_contact_id',
      'project_category_id',
      'parent_project_id',
      'is_archived',
      'hourly',
      'budget_hours',
      'budget_costs',
      'budget_period',
      'begin_on',
      'end_on',
      'website',
      'note',
      'avatar'
    ];
}
