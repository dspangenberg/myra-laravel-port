<?php

namespace App\Console\Commands;

use App\Models\Contact;
use App\Models\ConversionRate;
use App\Models\NumberRange;
use App\Models\Receipt;
use App\Models\ReceiptCategory;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\Confirm;
use function Laravel\Prompts\Table;

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
        $receiptCollection = collect($jsonContent);
        $category = $receiptCollection->values()->select('category')->values();
        $contacts = $receiptCollection->values()->select('iban', 'contact')->values();

        $category->each(function ($item) {
            $category = ReceiptCategory::query()->where('receipts_ref', $item['category']['id'])->first();
            if (! $category) {
                $category = new ReceiptCategory;
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
                if (! $contact) {
                    $contact = new Contact;
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

        $receiptCollection->reverse()->each(function ($item) {
            $item = collect($item)->dot();
            $date = Carbon::parse($item->get('date'), 'UTC')->setTimezone('Europe/Berlin');

            $receipt = Receipt::firstOrNew(['receipts_ref' => $item['id']]);
            $receipt->issued_on = $date;

            if (! $receipt->id) {
                $receipt->receipts_ref = $item['id'];
                $year = $date->year;
                $receipt->year = $year;
                $receipt->number_range_document_numbers_id = NumberRange::createDocumentNumber($receipt, 'issued_on');
            }

            $receipt->reference = $item->get('reference', '');

            $contactId = $item->get('contact.id', $item->get('provider.id'));
            if ($contactId) {
                $receipt->contact_id = Contact::query()->where('receipts_ref', $contactId)->first()->id;
            } else {
                $receipt->contact_id = 0;
            }

            $receipt->receipt_category_id = ReceiptCategory::query()->where('receipts_ref',
                $item->get('category.id'))->first()->id;
            // $receipt->issuedAt = $item['issuedAt'];

            $receipt->currency_code = $item->get('amountsOriginal.currency');
            // $receipt->tax_rate = $item->get('amountsOriginal.taxDetails.0.percent', 0);
            // $receipt->tax_code_number = $receipt->tax_rate !== 0 ? 85 : '';
            $receipt->amount = $item->get('amountsOriginal.gross');

            if ($receipt->amount != 0) {

                if ($receipt->currency_code !== 'EUR') {
                    // $receipt->tax_rate = 0;

                    $receipt->exchange_rate = ConversionRate::query()
                        ->where('currency_code', 'USD')
                        ->where('year', $receipt->issued_on->year)
                        ->where('month', $receipt->issued_on->month)
                        ->first()->rate;

                    $receipt->net = round($receipt->amount / $receipt->exchange_rate, 2);
                    $receipt->tax = 0;
                    $receipt->gross = $receipt->net;

                } else {
                    $receipt->gross = $receipt->amount;
                    $receipt->tax = 0;
                }

                $receipt->amount = $receipt->amount * -1;
                $receipt->gross = $receipt->gross * -1;
                $receipt->net = $receipt->net * -1;
                $receipt->tax = $receipt->tax * -1;

                $receipt->title = $item->get('title');
                $receipt->pdf_file = basename($item->get('asset.path'));
                $receipt->text = $item->get('text');

                $pdfContents = Storage::disk('system')->get("receipts/$receipt->pdf_file");
                $year = $receipt->issued_on->year;
                Storage::disk('s3')->put("documents/org-receipts/$year/$receipt->pdf_file", $pdfContents, 'private');

                $save = true;

                $duplicate = Receipt::query()
                    ->where('issued_on', $receipt->issued_on)
                    ->where('amount', $receipt->amount)
                    ->whereNot('receipts_ref', $receipt->receipts_ref)
                    ->first();

                if ($duplicate) {
                    table(
                        ['Datum', 'Kontakt', 'Betrag', 'Reference', 'MD5', 'RR'],
                        [
                            [
                                $duplicate->issued_on->format('d.m.Y'),
                                $duplicate->contact->name,
                                $duplicate->amount.''.$receipt->currency_code,
                                $duplicate->reference,
                                $duplicate->text_md5,
                                $duplicate->receipts_ref,
                            ],
                            [
                                $receipt->issued_on->format('d.m.Y'),
                                $receipt->contact->name,
                                $receipt->amount.''.$receipt->currency_code,
                                $receipt->reference,
                                $receipt->text_md5,
                                $receipt->receipts_ref,
                            ],
                        ]
                    );

                    $save = confirm('Mögliches Duplikate importieren?');
                }

                if ($save) {
                    $receipt->save();
                    Receipt::createBooking($receipt);
                }
            }
            // print_r($receipt->toJSON());

        });
    }
}
