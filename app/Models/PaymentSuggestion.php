<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
 * @mixin \Eloquent
 */
class PaymentSuggestion extends Model
{
    protected $fillable = [
        'receipt_id',
        'transaction_id',
        'confidence',
    ];
}
