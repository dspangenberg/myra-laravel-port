<?php

namespace App\Models;

use DateTimeInterface;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;

/**
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
 *
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
 *
 * @property string $issued_on
 * @property string|null $tax_code_number
 *
 * @method static Builder|Receipt whereIssuedOn($value)
 * @method static Builder|Receipt whereTaxCodeNumber($value)
 *
 * @property string $type
 * @property int|null $document_number
 * @property int $year
 * @property float $amount_to_pay
 * @property string|null $text_md5
 * @property int $is_locked
 * @property string|null $note
 * @property-read ReceiptCategory|null $category
 * @property-read Contact|null $contact
 * @property-read string $real_document_number
 *
 * @method static Builder|Receipt whereAmountToPay($value)
 * @method static Builder|Receipt whereDocumentNumber($value)
 * @method static Builder|Receipt whereIsLocked($value)
 * @method static Builder|Receipt whereNote($value)
 * @method static Builder|Receipt whereTextMd5($value)
 * @method static Builder|Receipt whereType($value)
 * @method static Builder|Receipt whereYear($value)
 *
 * @property-read BookkeepingBooking|null $booking
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property int $number_range_document_numbers_id
 *
 * @method static Builder|Receipt whereNumberRangeDocumentNumbersId($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payable
 * @property-read int|null $payable_count
 *
 * @mixin Eloquent
 */
class Receipt extends Model
{
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
        'text_md5',
    ];

    protected $appends = [
        'document_number',
    ];

    public static function createBooking($receipt): void
    {
        $receipt->load('category');
        $receipt->gross = $receipt->gross * -1;

        $accounts = Contact::getAccounts($receipt->contact_id);

        if ($accounts['outturnAccount'] === null) {
            $bookkeepingAccount = BookkeepingAccount::query()->where('account_number', $receipt->category->outturn_account_id)->first();
            if (! $bookkeepingAccount) {
                $bookkeepingAccount = BookkeepingAccount::query()->where('type', 'e')->where('is_default', true)->first();
            }

            $accounts['outturnAccount'] = $bookkeepingAccount;
        }

        $booking = BookkeepingBooking::whereMorphedTo('bookable', Receipt::class)->where('bookable_id', $receipt->id)->first();
        $booking = BookkeepingBooking::createBooking($receipt, 'issued_on', 'gross', $accounts['subledgerAccount'], $accounts['outturnAccount'], 'E', $booking ? $booking->id : null);
        $name = strtoupper($accounts['name']);

        $bookingTextSuffix = $receipt->currency_code !== 'EUR' ? number_format($receipt->amount * -1, 2, ',', '.').' '.$receipt->currency_code : '';
        if ($booking) {
            $booking->booking_text = "Rechnungseingang|$name|$receipt->reference|$bookingTextSuffix";
            $booking->save();
        }
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ReceiptCategory::class, 'receipt_category_id', 'id');
    }

    public function booking(): MorphOne
    {
        return $this->morphOne(BookkeepingBooking::class, 'bookable');
    }

    public function payable(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function getDocumentNumberAttribute(): string
    {
        return $this->range_document_number->document_number;
    }

    public function range_document_number(): HasOne
    {
        return $this->hasOne(NumberRangeDocumentNumber::class, 'id', 'number_range_document_numbers_id');
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
