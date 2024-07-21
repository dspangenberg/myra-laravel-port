<?php

namespace App\Http\Resources;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Contact
 */
class ContactResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company_id' => $this->company_id,
            'company' => $this->company,
            'name' => $this->name,
            'position' => $this->position,
            'short_name' => $this->position,
            'is_org' => $this->is_org,
            'is_debtor' => $this->is_debtor,
            'is_creditor' => $this->is_creditor,
            'outturn_account_id' => $this->outturn_account_id,
            'is_primary' => $this->is_primary,
            'is_archived' => $this->is_archived,
            'has_dunning_block' => $this->has_dunning_block,
            'payment_deadline_id' => $this->payment_deadline_id,
            'payment_deadline' => $this->payment_deadline,
            'tax_id' => $this->tax_id,
            'tax' => $this->tax,
            'hourly' => $this->hourly,
            'register_court' => $this->register_court,
            'register_number' => $this->register_number,
            'vat_id' => $this->vat_id,
            'website' => $this->website,
            'dob' => $this->dob,
            'archived_reason' => $this->archived_reason,
            'department' => $this->department,
            'first_name' => $this->first_name,
            'full_name' => $this->full_name,
            'debtor_number' => $this->debtor_number,
            'creditor_number' => $this->creditor_number,
            'reverse_full_name' => $this->reverse_full_name,
            'initials' => $this->initials,
            'salutation_id' => $this->salutation_id,
            'salutation' => $this->salutation(),
            'title_id' => $this->title_id,
            'title' => $this->title,
            'contacts' => $this->contacts,
            'addresses' => $this->addresses,
            'tax_number' => $this->tax_number,
            'phones' => $this->phones,
            'mails' => $this->mails,
        ];
    }
}
