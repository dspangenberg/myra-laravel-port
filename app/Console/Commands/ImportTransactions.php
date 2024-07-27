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
        $jsonTransactions = Storage::disk('private')->json('pbg-2021.json');
        $collection = collect($jsonTransactions);

        $account = $collection->get('account');
        $transactions = collect($collection->get('transactions'))->reverse();
        $ownBankAccounts = BankAccount::where('iban', $account['iban'])->get()->pluck('iban')->toArray();

        $transactions->each(function ($item) use ($account, $ownBankAccounts) {
            $item = collect($item)->dot();
            $bankAccount = BankAccount::query()->where('iban', $account['iban'])->first();

            if ($item->get('bookingDate', '')) {
                echo $item->get('id,');
                $transaction = Transaction::firstOrNew(['mm_ref' => $item->get('id')]);
                $transaction->bank_account_id = $bankAccount->id;
                $transaction->mm_ref = $item->get('id');
                $transaction->booked_on = Carbon::createFromTimestamp($item->get('bookingDate'));
                $transaction->valued_on = Carbon::createFromTimestamp($item->get('valueDate'));
                $transaction->amount = $item->get('amount');
                $transaction->currency = $item->get('currency');
                if ($transaction->currency === 'EUR') {
                    $transaction->amount_EUR = $item->get('amount');
                }
                $transaction->bank_code = $item->get('bankCode', '');
                $transaction->account_number = $item->get('accountNumber', '');
                $transaction->name = $item->get('name', '');
                $transaction->purpose = $item->get('purpose', '');
                $transaction->comment = $item->get('comment', '');
                $transaction->booking_key = $item->get('bookingKey', '');

                $transaction->booking_text = $item->get('bookingText', '');
                $transaction->type = $item->get('type', '');
                $transaction->return_reason = $item->get('returnReason', '');
                $transaction->transaction_code = $item->get('transactionCode', '');
                $transaction->end_to_end_reference = $item->get('endToEndReference', '');
                $transaction->mandate_reference = $item->get('mandateReference', '');
                $transaction->batch_reference = $item->get('batchReference', '');
                $transaction->primanota_number = $item->get('primanotaNumber', '');

                $transaction->contact_id = 0;

                if (substr_count($item->get('category'), 'privat') > 0) {
                    $transaction->is_private = true;
                } else {
                    if (in_array($transaction->bank_code, $ownBankAccounts) || $transaction->name === 'TWICEWARE SOLUTIONS E.K.' || substr_count($transaction->name, 'PAYPAL')) {
                        $transaction->is_transit = true;
                    } else {
                        $contact = false;
                        if ($transaction->account_number) {
                            $contact = Contact::query()->where('iban', $transaction->account_number)->first();
                        }
                        if (! $contact) {
                            $contact = Contact::query()->where('cc_name', 'LIKE', $transaction->name)->first();
                        }
                        if ($contact) {
                            $transaction->contact_id = $contact->id;
                        }
                    }
                }

                $transaction->save();
                $transaction->createBooking($transaction);
            }

        });
    }
}
