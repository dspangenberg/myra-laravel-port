<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
 * @mixin Eloquent
 */
class BookkeepingBooking extends Model
{
    protected $fillable = [
        'transaction_id',
        'receipt_id',
        'payment_id',
        'account_id_credit',
        'account_id_debit',
        'amount',
        'date',
        'tax_id',
        'is_split',
        'split_id',
        'booking_text',
        'document_number',
        'note',
        'tax_credit',
        'tax_debit',
        'is_locked',
    ];

    public function initBooking($type, $id, $date, $amount, $credit_account_id, $debit_account_id, $text, $document_number, $note)
    {

        $this->booking_text = $text;
        switch ($type) {
            case 'transaction':
                $this->transaction_id = $id;
                $transaction = Transaction::find($id);
                $this->booking_text = $text ? $text : $transaction->name.'|'.$transaction->purpose;
                break;
            case 'receipt':
                $this->receipt_id = $id;
                break;
            case 'payment':
                $this->payment_id = $id;
                break;
        }

        $this->document_number = $document_number;
        $this->account_id_credit = $amount < 0 ? $debit_account_id : $credit_account_id;
        $this->account_id_debit = $amount < 0 ? $credit_account_id : $debit_account_id;
        $this->amount = $amount < 0 ? $amount * -1 : $amount;

        $this->date = $date;
        $tax = BookkeepingAccount::getTax($this->account_id_credit, $this->account_id_debit, $this->amount);

        $this->tax_credit = $tax['tax_credit'];
        $this->tax_debit = $tax['tax_debit'];
        $this->tax_id = $tax['tax_id'];
        $this->note = $note;

    }

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

    protected function casts()
    {
        return [
            'date' => 'date',
        ];
    }
}
