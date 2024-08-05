<?php

namespace App\Console\Commands;

use App\Models\BankAccount;
use App\Models\Contact;
use App\Models\Transaction;
use App\Models\TransactionRule;
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
        $ownBankAccounts = BankAccount::where('iban', $account['iban'])->get()->pluck('iban')->toArray();
        $transactions->each(function ($item) use ($account, $ownBankAccounts) {
            $item = collect($item)->dot();
            dump($item);
            if ($item->count() > 0) {

                $bankAccount = BankAccount::query()->where('iban', $account['iban'])->first();
                if (! $bankAccount) {
                    $bankAccount = BankAccount::query()->where('iban', $account['accountNumber'])->first();
                }
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
                        $transaction->amount_in_foreign_currency = $item->get('amount');
                    }
                    $transaction->bank_code = $item->get('bankCode', '');
                    $transaction->account_number = $item->get('accountNumber', '');
                    $transaction->name = $item->get('name', '');
                    $transaction->purpose = $item->get('purpose', '');
                    $transaction->comment = $item->get('comment', '');
                    $transaction->booking_key = $item->get('bookingKey', '');
                    $transaction->org_category = $item->get('category', '');

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
                        if (in_array($transaction->bank_code, $ownBankAccounts)) {
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
                    if (! $transaction->is_private && ! $transaction->is_transit) {
                        $rules = TransactionRule::query()->where('table', 'transactions')->get();
                        $rules->each(function ($rule) use ($transaction) {
                            $trans = Transaction::query()->where('id', $transaction->id)->where($rule->search_field,
                                $rule->comparator, $rule->search_value)->first();
                            if ($trans) {
                                $transaction->setAttribute($rule->set_field, $rule->set_value);
                                $transaction->save();
                            }
                        });
                    }

                    $transaction->createBooking($transaction);
                }
            }
        });

    }
}
