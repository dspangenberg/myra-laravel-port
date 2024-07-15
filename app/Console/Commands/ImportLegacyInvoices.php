<?php

namespace App\Console\Commands;

use App\Models\Receipt;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Contact;

class ImportLegacyInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-legacy-invoices';

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
        $jsonInvoices = Storage::disk('private')->json('invoices.json');
        $jsonAccounts = Storage::disk('private')->json('accounts.json');

        $invoiceCollection = collect($jsonInvoices);
        $accountCollection = collect($jsonAccounts);

        $invoiceCollection->each(function ($item) use ($accountCollection) {
            $item = collect($item)->dot();

            $year = Carbon::parse($item['issued_on'])->year;
            if ($year === 2021) {
                $account = $accountCollection->where('id', $item['account_id'])->first();
                dump($account['account_id']);
                if ($account && $account['account_id']) {
                    $contact = Contact::query()->where('debtor_number', $account['account_id'])->first();
                    if ($contact) {
                        $receipt = new Receipt();
                        $receipt->contact_id = $contact->id;
                        $receipt->type = 'O';
                        $receipt->year = $year;
                        $receipt->receipts_ref = $item['id'];
                        $receipt->issued_on = Carbon::parse($item['issued_on']);
                        $receipt->net = $item['amount'];
                        $receipt->currency_code = 'EUR';
                        $receipt->receipt_category_id = 13;
                        $receipt->tax = $item['tax'];
                        $receipt->tax_rate = $item['tax'] === 0 ? 0 : 19;
                        $receipt->tax_code_number = $item['tax'] === 0 ? '21' : '81';
                        $receipt->reference = formated_invoice_id($item['invoice_number']);
                        $receipt->gross = $receipt->net + $receipt->tax;
                        $receipt->amount = $receipt->gross;
                        $receipt->amount_to_pay = $receipt->gross;
                        $lastDocumentNumber = Receipt::query()->where('type', 'O')->where('year',
                            $year)->max('document_number');
                        $lastDocumentNumber++;
                        $receipt->text = '';
                        $receipt->text_md5 = '';
                        $receipt->document_number = $lastDocumentNumber;
                        $receipt->save();
                    } else {
                        dd('No contact found for account: '.$item);
                    }
                }
            }
        });
    }
}
