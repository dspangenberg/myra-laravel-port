<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * 
 *
 * @property int $id
 * @property int $contact_id
 * @property int $project_id
 * @property int $invoice_number
 * @property Carbon $issued_on
 * @property Carbon $due_on
 * @property int $dunning_block
 * @property int $is_draft
 * @property int $type_id
 * @property string $service_provision
 * @property string $vat_id
 * @property string $address
 * @property int $payment_deadline_id
 * @property Carbon|null $sent_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Invoice newModelQuery()
 * @method static Builder|Invoice newQuery()
 * @method static Builder|Invoice query()
 * @method static Builder|Invoice whereAddress($value)
 * @method static Builder|Invoice whereContactId($value)
 * @method static Builder|Invoice whereCreatedAt($value)
 * @method static Builder|Invoice whereDueOn($value)
 * @method static Builder|Invoice whereDunningBlock($value)
 * @method static Builder|Invoice whereId($value)
 * @method static Builder|Invoice whereInvoiceNumber($value)
 * @method static Builder|Invoice whereIsDraft($value)
 * @method static Builder|Invoice whereIssuedOn($value)
 * @method static Builder|Invoice wherePaymentDeadlineId($value)
 * @method static Builder|Invoice whereProjectId($value)
 * @method static Builder|Invoice whereSentAt($value)
 * @method static Builder|Invoice whereServiceProvision($value)
 * @method static Builder|Invoice whereTypeId($value)
 * @method static Builder|Invoice whereUpdatedAt($value)
 * @method static Builder|Invoice whereVatId($value)
 * @property int $legacy_id
 * @property-read \App\Models\BookkeepingBooking|null $booking
 * @property-read string $formated_invoice_number
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InvoiceLine> $lines
 * @property-read int|null $lines_count
 * @method static Builder|Invoice whereLegacyId($value)
 * @property-read \App\Models\Contact|null $contact
 * @property-read \App\Models\PaymentDeadline|null $payment_deadline
 * @property-read \App\Models\Project|null $project
 * @mixin Eloquent
 */
class Invoice extends Model
{
    protected $fillable = [
        'contact_id',
        'project_id',
        'invoice_number',
        'issued_on',
        'due_on',
        'dunning_block',
        'is_draft',
        'type_id',
        'service_provision',
        'vat_id',
        'address',
        'payment_deadline_id',
        'sent_at',
    ];

    protected $attributes = [
        'dunning_block' => false,
        'project_id' => 0,
    ];

    protected $appends = [
        'formated_invoice_number',
    ];

    public static function createBooking($invoice): void
    {
        $invoice->load('lines');
        $invoice->amount = $invoice->lines->sum('amount');

        $accounts = Contact::getAccounts($invoice->contact_id, true, true);
        $booking = BookkeepingBooking::createBooking($invoice, 'issued_on', 'amount', $accounts['subledgerAccount'], $accounts['outturnAccount'], 'A');
        $name = $accounts['name'];
        $booking->booking_text = "{$name}|Rechnungsausgang|{$invoice->formatedInvoiceNumber}";
        $booking->save();
    }

    public function getFormatedInvoiceNumberAttribute(): string
    {
        return 'RG-'.formated_invoice_id($this->invoice_number);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(InvoiceLine::class);
    }

    public function contact(): HasOne
    {
        return $this->hasOne(Contact::class, 'id', 'contact_id');
    }

    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function payment_deadline(): HasOne
    {
        return $this->hasOne(PaymentDeadline::class, 'id', 'payment_deadline_id');
    }

    protected function casts(): array
    {
        return [
            'issued_on' => 'date',
            'due_on' => 'date',
            'sent_at' => 'datetime',
        ];
    }
}
