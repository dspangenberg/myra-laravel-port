<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
  protected $attributes = [
    'name' => '',
    'first_name' => '',
    'position' => '',
    'company_id' => 0,
    'department' => '',
    'short_name' => '',
    'is_org' => false,
    'is_debtor' => false,
    'is_creditor' => false,
    'is_archived' => false,
    'has_dunning_block' => false,
    'payment_deadline_id' => 0,
    'tax_id' => 0,
    'hourly' => 0,
    'register_court' => '',
    'register_number' => '',
    'vat_id' => '',
    'website' => '',
    'dob' => null,
    'archived_reason' => '',
    'deleted_at' => null
  ];

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
