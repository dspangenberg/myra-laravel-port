<?php

namespace App\Console\Commands;

use App\Models\Contact;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Project;
use App\Models\Tax;
use App\SushiModels\LegacyAccount;
use App\SushiModels\LegacyInvoice;
use App\SushiModels\LegacyInvoiceLine;
use App\SushiModels\LegacyProject;
use Illuminate\Console\Command;

class ConvertInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $invoices = LegacyInvoice::query()->whereBetween('issued_on', ['2021-01-01', '2021-12-31'])->get();
        $invoices->each(function ($legacyInvoice) {
            $account = LegacyAccount::query()->where('id', $legacyInvoice->account_id)->first();
            $contact = Contact::query()->where('debtor_number', $account->account_id)->first();

            $lProject = LegacyProject::query()->where('id', $legacyInvoice->project_id)->first();
            $invoice = new Invoice();

            if ($lProject) {
                $project = Project::query()->where('name', $lProject->name)->firstOrNew();
                if (! $project->id) {
                    $project->name = $lProject->name;
                    $project->owner_contact_id = $contact->id;
                    $project->is_archived = $lProject->is_archived;
                    $project->hourly = $lProject->price_per_hour || 0;
                    $project->save();
                }
                $invoice->project_id = $project ? $project->id : 0;
            }

            $vatId = '';
            if ($legacyInvoice->vat_id) {
                $vatId = $legacyInvoice->vat_id;
            } else {
                if ($contact->vat_id) {
                    $vatId = $contact->vat_id;
                }
            }

            $invoice->legacy_id = $legacyInvoice->id;
            $invoice->contact_id = $contact->id;
            $invoice->invoice_number = $legacyInvoice->invoice_number;
            $invoice->issued_on = $legacyInvoice->issued_on;
            $invoice->due_on = $legacyInvoice->due_on;
            $invoice->dunning_block = $legacyInvoice->dunning_block || false;
            $invoice->is_draft = $legacyInvoice->is_draft;
            $invoice->type_id = $legacyInvoice->type_id || 0;
            $invoice->service_provision = $legacyInvoice->service_provision;
            $invoice->vat_id = $vatId;
            $invoice->address = $legacyInvoice->address;
            $invoice->payment_deadline_id = $legacyInvoice->payment_deadline_id || 1;
            $invoice->sent_at = $legacyInvoice->sent_at;
            $invoice->save();

            $legacyInvoiceLines = LegacyInvoiceLine::query()->where('invoice_id', $legacyInvoice->id)->orderBy('pos')->orderBy('id')->get();

            $lineCounter = 0;
            $legacyInvoiceLines->each(function ($legacyInvoiceLine) use ($invoice, $lineCounter) {

                $tax = Tax::query()->where('legacy_id', $legacyInvoiceLine->tax_id)->first();

                if (! $tax) {
                    $tax = Tax::query()->where('is_default', true)->first();
                }

                $lineCounter++;
                $invoiceLine = new InvoiceLine();
                $invoiceLine->invoice_id = $invoice->id;
                $invoiceLine->text = $legacyInvoiceLine->text;
                $invoiceLine->quantity = $legacyInvoiceLine->quantity;
                $invoiceLine->unit = $legacyInvoiceLine->unit;
                $invoiceLine->price = $legacyInvoiceLine->price;
                $invoiceLine->amount = $legacyInvoiceLine->amount;
                $invoiceLine->tax_id = $tax->id;
                $invoiceLine->tax = $legacyInvoiceLine->tax;
                $invoiceLine->type_id = $legacyInvoiceLine->type;
                $invoiceLine->legacy_id = $legacyInvoiceLine->id;
                $invoiceLine->pos = $lineCounter;
                $invoiceLine->save();
            });
            Invoice::createBooking($invoice);

        });
    }
}
