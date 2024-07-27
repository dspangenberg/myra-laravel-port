<?php

namespace App\SushiModels;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Sushi\Sushi;

/**
 * 
 *
 * @property int $id
 * @property int|null $contact_id
 * @property int|null $account_category_id
 * @property int|null $account_id
 * @property string|null $vat_id
 * @property int|null $is_dunning_block
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $invoice_contact_id
 * @property string|null $ref
 * @property int|null $default_tax_id
 * @property int|null $price_per_hour
 * @property int|null $payment_deadline_id
 * @property int|null $invoice_shipment_id
 * @property string|null $debtor_id
 * @property string|null $creditor_id
 * @property string|null $standard_account_id
 * @method static Builder|LegacyAccount newModelQuery()
 * @method static Builder|LegacyAccount newQuery()
 * @method static Builder|LegacyAccount query()
 * @method static Builder|LegacyAccount whereAccountCategoryId($value)
 * @method static Builder|LegacyAccount whereAccountId($value)
 * @method static Builder|LegacyAccount whereContactId($value)
 * @method static Builder|LegacyAccount whereCreatedAt($value)
 * @method static Builder|LegacyAccount whereCreditorId($value)
 * @method static Builder|LegacyAccount whereDebtorId($value)
 * @method static Builder|LegacyAccount whereDefaultTaxId($value)
 * @method static Builder|LegacyAccount whereId($value)
 * @method static Builder|LegacyAccount whereInvoiceContactId($value)
 * @method static Builder|LegacyAccount whereInvoiceShipmentId($value)
 * @method static Builder|LegacyAccount whereIsDunningBlock($value)
 * @method static Builder|LegacyAccount wherePaymentDeadlineId($value)
 * @method static Builder|LegacyAccount wherePricePerHour($value)
 * @method static Builder|LegacyAccount whereRef($value)
 * @method static Builder|LegacyAccount whereStandardAccountId($value)
 * @method static Builder|LegacyAccount whereUpdatedAt($value)
 * @method static Builder|LegacyAccount whereVatId($value)
 * @mixin Eloquent
 */
class LegacyAccount extends Model
{
    use Sushi;

    public function getRows(): array
    {
        $jsonInvoices = Storage::disk('private')->json('accounts.json');

        return collect($jsonInvoices)->toArray();
    }
}
