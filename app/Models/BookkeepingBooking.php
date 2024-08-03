<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $transaction_id
 * @property int $receipt_id
 * @property int $payment_id
 * @property int $account_id_credit
 * @property string $account_id_debit
 * @property float $amount
 * @property Carbon $date
 * @property int $tax_id
 * @property int $is_split
 * @property int $split_id
 * @property string $booking_text
 * @property string $document_number
 * @property string|null $note
 * @property float $tax_credit
 * @property float $tax_debit
 * @property int $is_locked
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|BookkeepingBooking newModelQuery()
 * @method static Builder|BookkeepingBooking newQuery()
 * @method static Builder|BookkeepingBooking query()
 * @method static Builder|BookkeepingBooking whereAccountIdCredit($value)
 * @method static Builder|BookkeepingBooking whereAccountIdDebit($value)
 * @method static Builder|BookkeepingBooking whereAmount($value)
 * @method static Builder|BookkeepingBooking whereBookingText($value)
 * @method static Builder|BookkeepingBooking whereCreatedAt($value)
 * @method static Builder|BookkeepingBooking whereDate($value)
 * @method static Builder|BookkeepingBooking whereDocumentNumber($value)
 * @method static Builder|BookkeepingBooking whereId($value)
 * @method static Builder|BookkeepingBooking whereIsLocked($value)
 * @method static Builder|BookkeepingBooking whereIsSplit($value)
 * @method static Builder|BookkeepingBooking whereNote($value)
 * @method static Builder|BookkeepingBooking wherePaymentId($value)
 * @method static Builder|BookkeepingBooking whereReceiptId($value)
 * @method static Builder|BookkeepingBooking whereSplitId($value)
 * @method static Builder|BookkeepingBooking whereTaxCredit($value)
 * @method static Builder|BookkeepingBooking whereTaxDebit($value)
 * @method static Builder|BookkeepingBooking whereTaxId($value)
 * @method static Builder|BookkeepingBooking whereTransactionId($value)
 * @method static Builder|BookkeepingBooking whereUpdatedAt($value)
 *
 * @property-read BookkeepingAccount|null $account_credit
 * @property-read BookkeepingAccount|null $account_debit
 * @property-read Tax|null $tax
 * @property string $bookable_type
 * @property int $bookable_id
 * @property int $is_marked
 * @property-read Model|Eloquent $bookable
 *
 * @method static Builder|BookkeepingBooking whereBookableId($value)
 * @method static Builder|BookkeepingBooking whereBookableType($value)
 * @method static Builder|BookkeepingBooking whereIsMarked($value)
 *
 * @property string $document_number_prefix
 * @property int $document_number_counter
 *
 * @method static Builder|BookkeepingBooking whereDocumentNumberCounter($value)
 * @method static Builder|BookkeepingBooking whereDocumentNumberPrefix($value)
 *
 * @mixin Eloquent
 */
class BookkeepingBooking extends Model
{
    protected $fillable = [
        'account_id_credit',
        'account_id_debit',
        'amount',
        'date',
        'tax_id',
        'is_split',
        'split_id',
        'booking_text',
        'document_number_prefix',
        'document_number_year',
        'document_number',
        'is_split',
        'split_id',
        'note',
        'tax_credit',
        'tax_debit',
        'is_locked',
        'is_marked',
        'bookable_type',
        'bookable_id',
    ];

    protected $appends = [
        'document_number',
    ];

    public static function createBooking($parent, $dateField, $amountField, $debit_account, $credit_account, $documentNumberPrefix = ''): BookkeepingBooking
    {
        $booking = new BookkeepingBooking;
        $booking->bookable()->associate($parent);
        $booking->date = $parent[$dateField];

        $amount = $parent[$amountField];
        $booking->amount = $amount < 0 ? $amount * -1 : $amount;

        if ($parent->amount < 0) {
            $booking->account_id_credit = $debit_account->account_number;
            $booking->account_id_debit = $credit_account->account_number;
        } else {
            $booking->account_id_debit = $debit_account->account_number;
            $booking->account_id_credit = $credit_account->account_number;
        }

        $prefix = $documentNumberPrefix !== '' ? $documentNumberPrefix : $parent->prefix;
        $booking->document_number_prefix = $prefix;
        $booking->document_number_year = $booking->date->year;

        $booking->setDocumentNumber($booking->date->year, $prefix);

        $taxes = BookkeepingAccount::getTax($booking->account_id_credit, $booking->account_id_debit, $booking->amount);
        $booking->tax_credit = $taxes['tax_credit'];
        $booking->tax_debit = $taxes['tax_debit'];
        $booking->tax_id = $taxes['tax_id'];

        return $booking;
    }

    public function bookable(): MorphTo
    {
        return $this->morphTo();
    }

    public function setDocumentNumber($year, $prefix): void
    {
        $lastDocumentNumber = BookkeepingBooking::query()->where('document_number_prefix', $prefix)->where('document_number_year',
            $year)->max('document_number_counter');
        $lastDocumentNumber++;

        $this->document_number_prefix = $prefix;
        $this->document_number_year = $year;
        $this->document_number_counter = $lastDocumentNumber;

    }

    public function initBooking(MorphTo $parent, $date, $amount, $credit_account, $debit_account, $text, $document_number, $note): void {}

    public function account_credit(): HasOne
    {
        return $this->hasOne(BookkeepingAccount::class, 'account_number', 'account_id_credit');
    }

    public function account_debit(): HasOne
    {
        return $this->hasOne(BookkeepingAccount::class, 'account_number', 'account_id_debit');
    }

    public function tax(): HasOne
    {
        return $this->hasOne(Tax::class, 'id', 'tax_id');
    }

    public function getDocumentNumberAttribute(): string
    {
        return $this->document_number_prefix.'-'.$this->date->year.'-'.$this->document_number_counter;
    }

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }
}
