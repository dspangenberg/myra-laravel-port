<?php

namespace App\Console\Commands;

use App\Models\Contact;
use App\Models\ConversionRate;
use App\Models\Receipt;
use App\Models\ReceiptCategory;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class ImportReceipts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-receipts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $jsonContent = Storage::disk('private')->json('receipts-2021.json');
        $recieptCollection = collect($jsonContent);
        $category = $recieptCollection->values()->select('category')->values();
        $contacts = $recieptCollection->values()->select('iban', 'contact')->values();

        $category->each(function ($item) {
            $category = ReceiptCategory::query()->where('receipts_ref', $item['category']['id'])->first();
            if (!$category) {
                $category = new ReceiptCategory();
                $category->receipts_ref = $item['category']['id'];
                $category->name = $item['category']['title'];
                $category->save();
            }
        });

        $contacts->each(function ($item) {
            $item = collect($item);
            if (Arr::exists($item, 'contact')) {
                $orgContact = $item->get('contact', $item->get('provider'));

                $contact = Contact::query()->where('receipts_ref', $orgContact)->first();
                if (!$contact) {
                    $contact = new Contact();
                    $contact->receipts_ref = $orgContact['id'];
                    $contact->name = $orgContact['title'];
                    $contact->is_creditor = true;
                }
                if (Arr::exists($item, 'iban')) {
                    $contact->iban = $item['iban'];
                }
                $contact->save();
            }
        });

        $recieptCollection->reverse()->each(function ($item) {
            $item = collect($item)->dot();

            $date = Carbon::parse($item->get('date'), 'UTC')->setTimezone('Europe/Berlin');


            $receipt = Receipt::query()->where('receipts_ref', $item['id'])->first();
            if (!$receipt) {
                $receipt = new Receipt();
                $receipt->receipts_ref = $item['id'];
                $year = $date->year;
                $lastDocumentNumber = Receipt::query()->where('type', 'I')->where('year',
                    $year)->max('document_number');
                $lastDocumentNumber++;
                $receipt->year = $year;
                $receipt->type = 'I';
                $receipt->document_number = $lastDocumentNumber;
            }


            $receipt->reference = $item->get('reference', '');

            $contactId = $item->get('contact.id', $item->get('provider.id'));
            if ($contactId) {
                $receipt->contact_id = Contact::query()->where('receipts_ref', $contactId)->first()->id;
            } else {
                $receipt->contact_id = 0;
            }

            $receipt->issued_on = $date;
            $receipt->receipt_category_id = ReceiptCategory::query()->where('receipts_ref',
                $item->get('category.id'))->first()->id;
            // $receipt->issuedAt = $item['issuedAt'];


            $receipt->tax_rate = $item->get('amountsOriginal.taxDetails.0.percent', 0);
            $receipt->tax_code_number = $receipt->tax_rate !== 0 ? 85 : '';

            if ($receipt->tax_rate === 0) {
                if ($receipt->currency_code !== 'EUR') {
                    $receipt->tax_rate = 19;
                    $receipt->tax_code_number = 67;
                }
            }


            $receipt->amount = $item->get('amountsOriginal.gross');
            if ($receipt->amount != 0) {
                $receipt->currency_code = $item->get('amountsOriginal.currency');

                $receipt->amount = $item->get('amountsOriginal.gross') * -1;

                $receipt->title = $item->get('title');
                $receipt->pdf_file = $item->get('asset.path');
                $receipt->text = $item->get('text');

                if ($receipt->currency_code === 'USD') {
                    $receipt->exchange_rate = ConversionRate::query()
                        ->where('currency_code', 'USD')
                        ->where('year', $receipt->issued_on->year)
                        ->where('month', $receipt->issued_on->month)
                        ->first()->rate;

                    $receipt->gross = round($receipt->amount / $receipt->exchange_rate, 2);
                } else {
                    $receipt->gross = $receipt->amount;
                }


                $receipt->tax = round(($receipt->gross / ($receipt->tax_rate + 100) * $receipt->tax_rate), 2);
                $receipt->net = round($receipt->gross - $receipt->tax, 2);

                $duplicate = Receipt::query()
                    ->whereNot('receipts_ref', $item->get('id'))
                    ->where('issued_on', $receipt->issued_on)
                    ->where('contact_id', $receipt->contact_id)
                    ->where('amount', $receipt->amount)
                    ->where('reference', $receipt->reference)
                    ->first();

                if ($duplicate) {
                    dump('Duplicate Receipt: '. $duplicate);
                } else {
                    $receipt->save();
                }




            }
            // print_r($receipt->toJSON());

        });
    }
}
