<?php

namespace App\Models;

use App\Observers\TransactionObserver;
use Eloquent;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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
 * @property int $is_transit
 * @property int|null $booking_id
 *
 * @method static Builder|Transaction whereBookingId($value)
 * @method static Builder|Transaction whereIsTransit($value)
 *
 * @property string|null $org_category
 * @property-read string $bookkepping_text
 *
 * @method static Builder|Transaction whereOrgCategory($value)
 *
 * @property float $amount_in_foreign_currency
 *
 * @method static Builder|Transaction whereAmountInForeignCurrency($value)
 *
 * @property int $number_range_document_numbers_id
 *
 * @method static Builder|Transaction whereNumberRangeDocumentNumbersId($value)
 *
 * @mixin Eloquent
 */
class Transaction extends Model
{
    protected $fillable = [
        'mm_ref',
    ];

    protected $appends = [
        'bookkepping_text',
        'document_number',
    ];

    public static function createBooking($transaction): void
    {

        $transaction->load('bank_account');
        $booking = BookkeepingBooking::whereMorphedTo('bookable', Transaction::class)->where('bookable_id', $transaction->id)->first();

        $accounts = [
            'creditId' => '',
            'debitId' => '',
        ];

        if ($transaction->is_private) {
            $accounts['creditId'] = $transaction->amount < 0 ? 1800 : 1890;
            $accounts['debitId'] = $transaction->bank_account->bookkeeping_account_id;
        }

        if ($transaction->is_transit) {
            $accounts['debitId'] = 1360;

            if ($transaction->bank_account) {
                $accounts['creditId'] = $transaction->bank_account->bookkeeping_account_id;
            } else {
                $accounts['creditId'] = 1250;
            }
        }

        $accountDebit = BookkeepingAccount::where('account_number', $accounts['debitId'])->first();
        $accountCredit = BookkeepingAccount::where('account_number', $accounts['creditId'])->first();

        if ($transaction->is_private) {
            // $accounts['bookingText'] = $transaction->bookkepping_text;
        }

        if ($transaction->is_transit) {
            // $accounts['bookingText'] = "Geldtransit|$transaction->booking_text|$transaction->purpose";
        }

        if (! $accounts['creditId']) {
            $accounts = Contact::getAccounts($transaction->contact_id);

            if ($accounts['subledgerAccount']) {
                $accountCredit = $accounts['subledgerAccount'];
            } else {
                if ($accounts['outturnAccount']) {
                    $accountCredit = $accounts['outturnAccount'];
                }
            }

            if ($transaction->bank_account) {
                $accountDebit = BookkeepingAccount::where('account_number', $transaction->bank_account->bookkeeping_account_id)->first();
                dump($accountDebit);
            }
        }

        if ($accountDebit && $accountCredit) {

            $booking = BookkeepingBooking::createBooking($transaction, 'booked_on', 'amount', $accountDebit,
                $accountCredit, $transaction->bank_account->prefix,
                $booking ? $booking->id : null
            );

            $booking->booking_text = $transaction->bookkepping_text;
            $booking->save();
            // dump($booking->toArray());
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

    public function getDocumentNumberAttribute(): string
    {
        return $this->range_document_number->document_number;
    }

    public function range_document_number(): HasOne
    {
        return $this->hasOne(NumberRangeDocumentNumber::class, 'id', 'number_range_document_numbers_id');
    }

    public function getBookkeppingTextAttribute(): string
    {
        $lines = [];

        if ($this->booking_key === 'MSC') {
            if ($this->is_transit) {
                $this->booking_text = $this->amount < 0 ? 'Überweisung' : 'Gutschrift';
            } else {
                if ($this->account_number === '') {
                    $this->booking_text = 'Kreditkartenzahlung';
                }
            }

        }

        if ($this->booking_text) {
            $private = $this->is_private ? ' (privat)' : '';
            $lines[] = $this->booking_text.$private;
        }

        $lines[] = strtoupper($this->name);

        if ($this->name !== $this->purpose) {
            $lines[] = $this->purpose;
        }

        return implode('|', array_filter($lines));
    }

    public function bank_account(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function payable(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    protected function casts(): array
    {
        return [
            'valued_on' => 'date',
            'booked_on' => 'date',
        ];
    }
}
