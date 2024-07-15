<?php

namespace App\Models;

use DateTimeInterface;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Receipt newModelQuery()
 * @method static Builder|Receipt newQuery()
 * @method static Builder|Receipt query()
 * @method static Builder|Receipt whereAmount($value)
 * @method static Builder|Receipt whereContactId($value)
 * @method static Builder|Receipt whereCreatedAt($value)
 * @method static Builder|Receipt whereCurrencyCode($value)
 * @method static Builder|Receipt whereExchangeRate($value)
 * @method static Builder|Receipt whereExportFileName($value)
 * @method static Builder|Receipt whereGross($value)
 * @method static Builder|Receipt whereId($value)
 * @method static Builder|Receipt whereIssuedAt($value)
 * @method static Builder|Receipt whereNet($value)
 * @method static Builder|Receipt wherePdfFile($value)
 * @method static Builder|Receipt whereReceiptCategoryId($value)
 * @method static Builder|Receipt whereReceiptsRef($value)
 * @method static Builder|Receipt whereReference($value)
 * @method static Builder|Receipt whereTax($value)
 * @method static Builder|Receipt whereTaxRate($value)
 * @method static Builder|Receipt whereText($value)
 * @method static Builder|Receipt whereTitle($value)
 * @method static Builder|Receipt whereUpdatedAt($value)
 * @property string $issued_on
 * @property string|null $tax_code_number
 * @method static Builder|Receipt whereIssuedOn($value)
 * @method static Builder|Receipt whereTaxCodeNumber($value)
 * @mixin Eloquent
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
        'amount_to_pay',
        'document_number',
        'type',
        'year',
        'text',
        'amount_to_pay',
        'text_md5'
    ];

    protected $appends = [
        'real_document_number',
    ];

    public function getRealDocumentNumberAttribute(): string
    {
        $documentNumber = $this->type === 'I'? 'E' : 'A';

        return $documentNumber . '-' . $this->year. '/'. $this->document_number;
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ReceiptCategory::class, 'receipt_category_id', 'id');
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('d.m.Y');
    }

    protected function casts(): array
    {
        return [
            'issued_on' => 'date',
        ];
    }

}
