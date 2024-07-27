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
 * @property int|null $user_id
 * @property int|null $account_id
 * @property int|null $project_id
 * @property int|null $invoice_number
 * @property string|null $issued_on
 * @property string|null $due_on
 * @property int|null $amount
 * @property float|null $tax
 * @property int|null $dunning_block
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $is_draft
 * @property int|null $is_dept_order
 * @property int|null $dunning_level
 * @property int|null $type
 * @property string|null $service_provision
 * @property string|null $dept_order_on
 * @property string|null $dept_order_file
 * @property string|null $mandate_reference
 * @property string|null $contact_id
 * @property string|null $bank_account_id
 * @property string|null $vat_id
 * @property string|null $sent_at
 * @property string|null $address
 * @property string|null $template
 * @property int|null $note_paper_id
 * @property string|null $sent_by
 * @property string|null $note
 * @property string|null $last_reminder_on
 * @property string|null $reminder_due_on
 * @property int|null $payment_deadline_id
 * @method static Builder|LegacyInvoice newModelQuery()
 * @method static Builder|LegacyInvoice newQuery()
 * @method static Builder|LegacyInvoice query()
 * @method static Builder|LegacyInvoice whereAccountId($value)
 * @method static Builder|LegacyInvoice whereAddress($value)
 * @method static Builder|LegacyInvoice whereAmount($value)
 * @method static Builder|LegacyInvoice whereBankAccountId($value)
 * @method static Builder|LegacyInvoice whereContactId($value)
 * @method static Builder|LegacyInvoice whereCreatedAt($value)
 * @method static Builder|LegacyInvoice whereDeptOrderFile($value)
 * @method static Builder|LegacyInvoice whereDeptOrderOn($value)
 * @method static Builder|LegacyInvoice whereDueOn($value)
 * @method static Builder|LegacyInvoice whereDunningBlock($value)
 * @method static Builder|LegacyInvoice whereDunningLevel($value)
 * @method static Builder|LegacyInvoice whereId($value)
 * @method static Builder|LegacyInvoice whereInvoiceNumber($value)
 * @method static Builder|LegacyInvoice whereIsDeptOrder($value)
 * @method static Builder|LegacyInvoice whereIsDraft($value)
 * @method static Builder|LegacyInvoice whereIssuedOn($value)
 * @method static Builder|LegacyInvoice whereLastReminderOn($value)
 * @method static Builder|LegacyInvoice whereMandateReference($value)
 * @method static Builder|LegacyInvoice whereNote($value)
 * @method static Builder|LegacyInvoice whereNotePaperId($value)
 * @method static Builder|LegacyInvoice wherePaymentDeadlineId($value)
 * @method static Builder|LegacyInvoice whereProjectId($value)
 * @method static Builder|LegacyInvoice whereReminderDueOn($value)
 * @method static Builder|LegacyInvoice whereSentAt($value)
 * @method static Builder|LegacyInvoice whereSentBy($value)
 * @method static Builder|LegacyInvoice whereServiceProvision($value)
 * @method static Builder|LegacyInvoice whereTax($value)
 * @method static Builder|LegacyInvoice whereTemplate($value)
 * @method static Builder|LegacyInvoice whereType($value)
 * @method static Builder|LegacyInvoice whereUpdatedAt($value)
 * @method static Builder|LegacyInvoice whereUserId($value)
 * @method static Builder|LegacyInvoice whereVatId($value)
 * @mixin Eloquent
 */
class LegacyInvoice extends Model
{
    use Sushi;

    public function getRows(): array
    {

        $jsonInvoices = Storage::disk('private')->json('invoices.json');

        return collect($jsonInvoices)->toArray();
    }
}
