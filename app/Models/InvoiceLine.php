<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $invoice_id
 * @property float|null $quantity
 * @property string|null $unit
 * @property string $text
 * @property float|null $price
 * @property float|null $amount
 * @property float|null $tax
 * @property int $tax_id
 * @property int $pos
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $type_id
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereUpdatedAt($value)
 * @property int $legacy_id
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceLine whereLegacyId($value)
 * @mixin \Eloquent
 */
class InvoiceLine extends Model
{
    protected $fillable = [
        'invoice_id',
        'quantity',
        'unit',
        'text',
        'price',
        'amount',
        'tax',
        'tax_id',
        'pos',
    ];
}
