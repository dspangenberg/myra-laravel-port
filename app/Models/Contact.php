<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
      'company_id',
      'is_org',
      'name',
      'title_id',
      'salutation_id',
      'first_name',
      'position',
      'department',
      'short_name',
      'ref',
      'catgory_id',
      'is_debtor',
      'is_creditor',
      'creditor_number',
      'debtor_number',
      'is_archived',
      'archived_reason',
      'has_dunning_block',
      'payment_deadline_id',
      'tax_id',
      'hourly',
      'register_court',
      'register_number',
      'vat_id',
      'website',
      'dob'
    ];
}
