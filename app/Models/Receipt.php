<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string $receipts_ref
 * @property string $reference
 * @property int $receipt_category_id
 * @property int $contact_id
 * @property string $issuedAt
 * @property int $tax_rate
 * @property float $amount
 * @property string $currency_code
 * @property float $exchange_rate
 * @property float $gross
 * @property float $net
 * @property float $tax
 * @property string $title
 * @property string $pdf_file
 * @property string $export_file_name
 * @property string $text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt query()
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereExchangeRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereExportFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereGross($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereIssuedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereNet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt wherePdfFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereReceiptCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereReceiptsRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipts_ref',
        'reference',
        'receipt_category_id',
        'contact_id',
        'issued_on',
        'tax_rate',
        'amount',
        'currency_code',
        'exchange_rate',
        'gross',
        'net',
        'tax',
        'title',
        'pdf_file',
        'export_file_name',
        'text',
    ];

}
