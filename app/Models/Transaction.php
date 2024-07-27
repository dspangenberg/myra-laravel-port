<?php

namespace App\Models;

use App\Observers\TransactionObserver;
use Eloquent;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;

#[ObservedBy([TransactionObserver::class])]
/**
 * @property int $id
 * @property string $mm_ref
 * @property int $contact_id
 * @property int $bank_account_id
 * @property Carbon $valued_on
 * @property Carbon|null $booked_on
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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $prefix
 * @property int|null $document_number
 * @property int $year
 * @property-read BankAccount|null $bank_account
 * @property-read string $real_document_number
 *
 * @method static Builder|Transaction newModelQuery()
 * @method static Builder|Transaction newQuery()
 * @method static Builder|Transaction query()
 * @method static Builder|Transaction whereAccountNumber($value)
 * @method static Builder|Transaction whereAmount($value)
 * @method static Builder|Transaction whereAmountEUR($value)
 * @method static Builder|Transaction whereBankAccountId($value)
 * @method static Builder|Transaction whereBankCode($value)
 * @method static Builder|Transaction whereBookedOn($value)
 * @method static Builder|Transaction whereBookingKey($value)
 * @method static Builder|Transaction whereComment($value)
 * @method static Builder|Transaction whereContactId($value)
 * @method static Builder|Transaction whereCreatedAt($value)
 * @method static Builder|Transaction whereCurrency($value)
 * @method static Builder|Transaction whereDocumentNumber($value)
 * @method static Builder|Transaction whereId($value)
 * @method static Builder|Transaction whereIsPrivate($value)
 * @method static Builder|Transaction whereMmRef($value)
 * @method static Builder|Transaction whereName($value)
 * @method static Builder|Transaction wherePrefix($value)
 * @method static Builder|Transaction wherePurpose($value)
 * @method static Builder|Transaction whereUpdatedAt($value)
 * @method static Builder|Transaction whereValuedOn($value)
 * @method static Builder|Transaction whereYear($value)
 *
 * @property string|null $booking_text
 * @property string|null $type
 * @property string|null $return_reason
 * @property string|null $transaction_code
 * @property string|null $end_to_end_reference
 * @property string|null $mandate_reference
 * @property string|null $batch_reference
 * @property string|null $primanota_number
 *
 * @method static Builder|Transaction whereBatchReference($value)
 * @method static Builder|Transaction whereBookingText($value)
 * @method static Builder|Transaction whereEndToEndReference($value)
 * @method static Builder|Transaction whereMandateReference($value)
 * @method static Builder|Transaction wherePrimanotaNumber($value)
 * @method static Builder|Transaction whereReturnReason($value)
 * @method static Builder|Transaction whereTransactionCode($value)
 * @method static Builder|Transaction whereType($value)
 *
 * @property-read Contact|null $contact
 * @property-read \App\Models\BookkeepingBooking|null $booking
 *
 * @mixin Eloquent
 */
class Transaction extends Model
{
    protected $fillable = [
        'mm_ref',
    ];

    public static function createBooking($transaction): void
    {

        $transaction->load('bank_account');

        $accounts = [
            'creditId' => '',
            'debitId' => '',
            'bookingText' => ',',
        ];

        if ($transaction->is_private) {
            $accounts['creditId'] = $transaction->amount < 0 ? 1800 : 1890;
            $accounts['debitId'] = $transaction->bank_account->bookkeeping_account_id;
        }

        if ($transaction->is_transit) {
            $accounts['debitId'] = 1360;

            if ($transaction->bankAccount) {
                $accounts['creditId'] = $transaction->bankAccount->bookkeeping_account_id;
            } else {
                $accounts['creditId'] = ($transaction->name === 'TWICEWARE SOLUTIONS E.K.') ? 1250 : 1297;
            }

        }

        $accountDebit = BookkeepingAccount::where('account_number', $accounts['debitId'])->first();
        $accountCredit = BookkeepingAccount::where('account_number', $accounts['creditId'])->first();

        if ($transaction->is_private) {
            $accounts['bookingText'] = "$transaction->name|$transaction->purpose";
        }

        if ($transaction->is_transit) {
            $accounts['bookingText'] = "Geldtransit|$transaction->booking_text|$transaction->purpose";
        }

        if ($accountDebit && $accountCredit) {

            $booking = BookkeepingBooking::createBooking($transaction, 'booked_on', 'amount', $accountDebit,
                $accountCredit, $transaction->bank_account->prefix);

            $booking->booking_text = $accounts['bookingText'];
            $booking->save();
        }
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function booking(): MorphOne
    {
        return $this->morphOne(BookkeepingBooking::class, 'bookable');
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
