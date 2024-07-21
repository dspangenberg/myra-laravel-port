<?php

namespace App\Models;

use App\Observers\TransactionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([TransactionObserver::class])]
/**
 * @property int $id
 * @property string $mm_ref
 * @property int $contact_id
 * @property int $bank_account_id
 * @property \Illuminate\Support\Carbon $valued_on
 * @property \Illuminate\Support\Carbon|null $booked_on
 * @property string|null $comment
 * @property string $currency
 * @property string|null $booking_key
 * @property string|null $bank_code
 * @property string|null $account_number
 * @property string $name
 * @property string|null $purpose
 * @property float $amount
 * @property float $amount_EUR
 * @property int $is_private
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $prefix
 * @property int|null $document_number
 * @property int $year
 * @property-read \App\Models\BankAccount|null $bank_account
 * @property-read string $real_document_number
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmountEUR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereBankAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereBankCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereBookedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereBookingKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDocumentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereIsPrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereMmRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereValuedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereYear($value)
 *
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    protected $appends = [
        'real_document_number',
    ];

    protected $fillable = [
        'mm_ref',
    ];

    public function getRealDocumentNumberAttribute(): string
    {
        return $this->prefix.'-'.$this->year.'/'.$this->document_number;
    }

    public function bank_account(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class);
    }

    protected function casts(): array
    {
        return [
            'valued_on' => 'date',
            'booked_on' => 'date',
        ];
    }
}
