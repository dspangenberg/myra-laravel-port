<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * 
 *
 * @property int $id
 * @property int $receipt_id
 * @property string $transaction_id
 * @property int $confidence
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion whereConfidence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion whereReceiptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion whereUpdatedAt($value)
 * @property string $payable_type
 * @property int $payable_id
 * @property int $booking_id
 * @property float $amount
 * @property int $is_private
 * @property string $issued_on
 * @property int $is_confirmed
 * @property int $rank
 * @property string|null $deleted_at
 * @property-read Model|\Eloquent $payable
 * @property-read \App\Models\Transaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion whereIsConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion whereIsPrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion whereIssuedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion wherePayableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion wherePayableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentSuggestion whereRank($value)
 * @mixin \Eloquent
 */
class PaymentSuggestion extends Model
{
    protected $fillable = [
    ];

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
    }

    public function payable(): MorphTo
    {
        return $this->morphTo();
    }
}
