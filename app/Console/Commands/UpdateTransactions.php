<?php

namespace App\Console\Commands;

use App\Models\Contact;
use App\Models\Transaction;
use App\Models\TransactionRule;
use Illuminate\Console\Command;

class UpdateTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-transactions';

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
        $transactions = Transaction::where('contact_id', 0)->where('is_private', 0)->where('is_transit', 0)->get();
        $transactions->each(function ($transaction) {

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
        });
    }
}
