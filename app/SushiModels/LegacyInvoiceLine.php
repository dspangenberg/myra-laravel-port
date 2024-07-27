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
 * @property int|null $invoice_id
 * @property int|null $quantity
 * @property string|null $unit
 * @property string|null $text
 * @property int|null $price
 * @property int|null $amount
 * @property int|null $tax
 * @property int|null $type
 * @property string|null $tax_id
 * @property int|null $pos
 * @method static Builder|LegacyInvoiceLine newModelQuery()
 * @method static Builder|LegacyInvoiceLine newQuery()
 * @method static Builder|LegacyInvoiceLine query()
 * @method static Builder|LegacyInvoiceLine whereAmount($value)
 * @method static Builder|LegacyInvoiceLine whereId($value)
 * @method static Builder|LegacyInvoiceLine whereInvoiceId($value)
 * @method static Builder|LegacyInvoiceLine wherePos($value)
 * @method static Builder|LegacyInvoiceLine wherePrice($value)
 * @method static Builder|LegacyInvoiceLine whereQuantity($value)
 * @method static Builder|LegacyInvoiceLine whereTax($value)
 * @method static Builder|LegacyInvoiceLine whereTaxId($value)
 * @method static Builder|LegacyInvoiceLine whereText($value)
 * @method static Builder|LegacyInvoiceLine whereType($value)
 * @method static Builder|LegacyInvoiceLine whereUnit($value)
 * @mixin Eloquent
 */
class LegacyInvoiceLine extends Model
{
    use Sushi;

    public function getRows(): array
    {

        $jsonInvoices = Storage::disk('private')->json('invoice_lines.json');

        return collect($jsonInvoices)->toArray();
    }
}
