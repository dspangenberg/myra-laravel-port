<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * 
 *
 * @property int $id
 * @property int|null $company_id
 * @property int $is_org
 * @property string $name
 * @property int|null $title_id
 * @property int|null $salutation_id
 * @property string|null $first_name
 * @property string|null $position
 * @property string|null $department
 * @property string|null $short_name
 * @property string|null $ref
 * @property int|null $catgory_id
 * @property int|null $is_debtor
 * @property int|null $is_creditor
 * @property int|null $debtor_number
 * @property int|null $creditor_number
 * @property int|null $is_archived
 * @property string|null $archived_reason
 * @property int|null $has_dunning_block
 * @property int|null $payment_deadline_id
 * @property int|null $tax_id
 * @property string|null $hourly
 * @property string|null $register_court
 * @property string|null $register_number
 * @property string|null $vat_id
 * @property string|null $website
 * @property string|null $note
 * @property string|null $dob
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Contact|null $company
 * @property-read string $full_name
 * @property-read string $initials
 * @property-read string $reverse_full_name
 * @property-read Title|null $title
 * @method static Builder|Contact newModelQuery()
 * @method static Builder|Contact newQuery()
 * @method static Builder|Contact query()
 * @method static Builder|Contact whereArchivedReason($value)
 * @method static Builder|Contact whereCatgoryId($value)
 * @method static Builder|Contact whereCompanyId($value)
 * @method static Builder|Contact whereCreatedAt($value)
 * @method static Builder|Contact whereCreditorNumber($value)
 * @method static Builder|Contact whereDebtorNumber($value)
 * @method static Builder|Contact whereDeletedAt($value)
 * @method static Builder|Contact whereDepartment($value)
 * @method static Builder|Contact whereDob($value)
 * @method static Builder|Contact whereFirstName($value)
 * @method static Builder|Contact whereHasDunningBlock($value)
 * @method static Builder|Contact whereHourly($value)
 * @method static Builder|Contact whereId($value)
 * @method static Builder|Contact whereIsArchived($value)
 * @method static Builder|Contact whereIsCreditor($value)
 * @method static Builder|Contact whereIsDebtor($value)
 * @method static Builder|Contact whereIsOrg($value)
 * @method static Builder|Contact whereName($value)
 * @method static Builder|Contact whereNote($value)
 * @method static Builder|Contact wherePaymentDeadlineId($value)
 * @method static Builder|Contact wherePosition($value)
 * @method static Builder|Contact whereRef($value)
 * @method static Builder|Contact whereRegisterCourt($value)
 * @method static Builder|Contact whereRegisterNumber($value)
 * @method static Builder|Contact whereSalutationId($value)
 * @method static Builder|Contact whereShortName($value)
 * @method static Builder|Contact whereTaxId($value)
 * @method static Builder|Contact whereTitleId($value)
 * @method static Builder|Contact whereUpdatedAt($value)
 * @method static Builder|Contact whereVatId($value)
 * @method static Builder|Contact whereWebsite($value)
 * *
 * @property-read Salutation|null $salutation
 * @property-read PaymentDeadline|null $payment_deadline
 * @property-read Tax|null $tax
 * @property string|null $tax_number
 * @property-read Collection<int, ContactAddress> $addresses
 * @property-read int|null $addresses_count
 * @property-read Collection<int, Contact> $contacts
 * @property-read int|null $contacts_count
 * @method static Builder|Contact whereTaxNumber($value)
 * @property-read Collection<int, ContactMail> $mails
 * @property-read int|null $mails_count
 * @property-read Collection<int, ContactPhone> $phones
 * @property-read int|null $phones_count
 * @property string|null $receipts_ref
 * @property string|null $iban
 * @method static Builder|Contact whereIban($value)
 * @method static Builder|Contact whereReceiptsRef($value)
 * @mixin Eloquent
 */
class Contact extends Model
{
      protected $appends = [
        'full_name',
        'reverse_full_name',
        'initials',
    ];

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
        'deleted_at' => null,
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
        'receipts_ref',
        'iban',
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
        'tax_number',
        'website',
        'dob',
    ];

    protected function casts(): array
    {
        return [
            'is_org' => 'boolean',
            'is_debtor' => 'boolean',
            'is_creditor' => 'boolean',
            'is_archived' => 'boolean',
            'has_dunning_block' => 'boolean',
            'dob' => 'datetime'
        ];
    }

    public function getFullNameAttribute(): string
    {
        if ($this->first_name) {
            $title = $this->title ? $this->title->name : '';

            return trim("$title $this->first_name $this->name");
        }

        return $this->name;
    }

    public function getInitialsAttribute(): string
    {
        if ($this->first_name) {
            return substr($this->first_name, 0, 1).substr($this->name, 0, 1);
        }

        return substr($this->name, 0, 1);
    }

    public function getReverseFullNameAttribute(): string
    {
        if ($this->first_name) {
            $title = $this->title ? $this->title->name : '';

            return "$this->name, $this->first_name $title";
        }

        return $this->name;
    }

    public function company(): HasOne
    {
        return $this->hasOne(Contact::class, 'id', 'company_id');
    }

    public function title(): HasOne
    {
        return $this->hasOne(Title::class, 'id', 'title_id');
    }

    public function salutation(): HasOne
    {
        return $this->hasOne(Salutation::class, 'id', 'salutation_id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'company_id', 'id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(ContactAddress::class, 'contact_id', 'id');
    }

    public function phones(): HasMany
    {
        return $this->hasMany(ContactPhone::class, 'contact_id', 'id');
    }

    public function mails(): HasMany
    {
        return $this->hasMany(ContactMail::class, 'contact_id', 'id');
    }


    public function payment_deadline(): HasOne
    {
        return $this->hasOne(PaymentDeadline::class, 'id', 'payment_deadline_id');
    }

    public function tax(): HasOne
    {
        return $this->hasOne(Tax::class, 'id', 'tax_id');
    }
}
