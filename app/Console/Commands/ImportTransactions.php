<?php

namespace App\Console\Commands;

use App\Models\BankAccount;
use App\Models\Contact;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-transactions';

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
        $jsonTransactions = Storage::disk('private')->json('holv-2021.json');
        $collection = collect($jsonTransactions);

        $account = $collection->get('account');
        $transactions = collect($collection->get('transactions'))->reverse();
        $bankAcount = BankAccount::query()->where('iban', $account['iban'])->first();

        $transactions->each(function ($item) use ($bankAcount) {
            $item = collect($item)->dot();

            if ($item->get('bookingDate', '')) {
                echo $item->get('id,');
                $transaction = Transaction::firstOrNew(['mm_ref' => $item->get('id')]);
                $transaction->bank_account_id = $bankAcount->id;
                $transaction->mm_ref = $item->get('id');
                $transaction->booked_on = Carbon::createFromTimestamp($item->get('bookingDate'));
                $transaction->valued_on = Carbon::createFromTimestamp($item->get('valueDate'));
                $transaction->amount = $item->get('amount');
                $transaction->currency = $item->get('currency');
                if ($transaction->currency === 'EUR') {
                    $transaction->amount_EUR = $item->get('amount');
                }

                $transaction->year = Carbon::createFromTimestamp($item->get('bookingDate'))->year;
                $transaction->prefix = $bankAcount->prefix;
                $lastDocumentNumber = Transaction::query()->where('prefix', $bankAcount->prefix)->where('year',
                    $transaction->year)->max('document_number');
                $lastDocumentNumber++;

                $transaction->document_number = $lastDocumentNumber;
                $transaction->bank_code = $item->get('bankCode', '');
                $transaction->bank_code = $item->get('bankCode', '');
                $transaction->account_number = $item->get('accountNumber', '');
                $transaction->name = $item->get('name', '');
                $transaction->purpose = $item->get('purpose', '');
                $transaction->comment = $item->get('comment', '');
                $transaction->booking_key = $item->get('bookingKey', '');
                $transaction->contact_id = 0;

                if (substr_count($item->get('category'), 'privat') > 0) {
                    $transaction->is_private = true;
                } else {
                    if ($transaction->account_number) {
                        $contact = Contact::query()->where('iban', $transaction->account_number)->first();
                        if ($contact) {
                            $transaction->contact_id = $contact->id;
                        }
                    }
                }

                $transaction->save();
            }

        });
    }
}
