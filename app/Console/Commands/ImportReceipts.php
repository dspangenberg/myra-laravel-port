<?php

namespace App\Console\Commands;

use App\Models\Receipt;
use App\Models\ReceiptCategory;
use App\Models\ConversionRate;

use App\Models\Contact;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Carbon\Carbon;

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
                    $contact->is_debtor = true;
                }
                if (Arr::exists($item, 'iban')) {
                    $contact->iban = $item['iban'];
                }
                $contact->save();
            }
        });

        $recieptCollection->each(function ($item) {
            $item = collect($item)->dot();
            $receipt = Receipt::query()->where('receipts_ref', $item['id'])->first();
            if (!$receipt) {
                $receipt = new Receipt();
                $receipt->receipts_ref = $item['id'];
            }



                $receipt->reference = $item->get('reference', $item->get('title'));

                $contactId = $item->get('contact.id', $item->get('provider.id'));
                dump($contactId);
                if ($contactId) {
                    $receipt->contact_id = Contact::query()->where('receipts_ref', $contactId)->first()->id;
                } else {
                    $receipt->contact_id = 0;
                }

                $receipt->issued_on = Carbon::parse($item->get('date'));
                $receipt->receipt_category_id = ReceiptCategory::query()->where('receipts_ref', $item->get('category.id'))->first()->id;
                // $receipt->issuedAt = $item['issuedAt'];


                $receipt->tax_rate = $item->get('amountsOriginal.taxDetails.0.percent', 0);
                if ($receipt->contact_id != 71) {
                    if ($receipt->tax_rate == 19) {
                        $receipt->tax_code_number = 85;
                    } else {
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

                        $receipt->gross = round($receipt->amount * $receipt->exchange_rate, 2);
                    } else {
                        $receipt->gross = $receipt->amount;
                    }

                    $receipt->net = round($receipt->gross - ($receipt->gross * ($receipt->tax_rate / 100)), 2);
                    $receipt->tax = round($receipt->gross * ($receipt->tax_rate / 100),2);


                    $receipt->save();
                }
                // print_r($receipt->toJSON());

        });
    }
}
