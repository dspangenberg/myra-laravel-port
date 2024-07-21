<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $parent_id
 * @property string $transaction_id
 * @property string $paypal_reference_id
 * @property string $paypal_reference_id_type
 * @property string $transaction_event_code
 * @property string $transaction_initiation_date
 * @property string $transaction_updated_date
 * @property float $transaction_amount
 * @property string $transaction_currency
 * @property string $transaction_status
 * @property string $payer_name
 * @property string $payer_email
 * @property string $transaction_subject
 * @property string $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions query()
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions wherePayerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions wherePayerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions wherePaypalReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions wherePaypalReferenceIdType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereTransactionAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereTransactionCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereTransactionEventCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereTransactionInitiationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereTransactionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereTransactionSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereTransactionUpdatedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayPalTransactions whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PayPalTransactions extends Model
{
    protected $fillable = [
        'parent_id',
        'transaction_id',
        'paypal_reference_id',
        'paypal_reference_id_type',
        'transaction_event_code',
        'transaction_initiation_date',
        'transaction_updated_date',
        'transaction_amount',
        'transaction_currency',
        'transaction_status',
        'payer_name',
        'payer_email',
        'transaction_subject',
        'data',
    ];

    protected $attributes = [
        'parent_id' => 0,
    ];
    
}
