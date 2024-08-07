<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Models\PaymentSuggestion;
use App\Models\Receipt;
use App\Models\Transaction;
use App\Services\PaymentService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

use function Laravel\Prompts\search;
use function Laravel\Prompts\select;
use function Laravel\Prompts\table;
use function Laravel\Prompts\warning;

class AdjustReceipts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:adjust-receipts {receipt?} {transaction?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $ignoredContacts = [];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        PaymentSuggestion::truncate();

        if ($this->argument('receipt')) {
            $receipts = Receipt::with('contact')->where('id', $this->argument('receipt'))->get();
            if ($this->argument('transaction')) {

                $transaction = Transaction::find($this->argument('transaction'));

                $payment = new Payment;

                $payment->transaction_id = $transaction->id;
                $payment->amount = $transaction->amount;
                $payment->issued_on = $transaction->booked_on;
                $payment->payable()->associate($receipts[0]);
                $payment->is_confirmed = true;
                $payment->save();

                PaymentService::checkForCurrencyDifference($receipts[0], $payment);

                return false;
            }
        } else {
            $receipts = Receipt::whereDoesntHave('payable', function (Builder $query) {
                $query->where('is_confirmed', '=', '1');
            })
                ->with('contact')
                ->orderBy('issued_on')->get();
        }
        $receipts->each(function (Receipt $receipt) {
            table(
                ['ID', 'Datum', 'Kontakt', 'Orignalbetrag', 'Betrag', 'Referenz'],
                [
                    [
                        $receipt->id,
                        $receipt->issued_on->format('d.m.Y'),
                        $receipt->contact->name,
                        $receipt->amount.' '.$receipt->currency_code,
                        $receipt->gross,
                        $receipt->reference,
                    ],
                ],
            );

            $receipt->load('payable')->load('payable.transaction');

            if ($receipt->payable && $receipt->payable->count() && $receipt->payable[0]->is_confirmed) {
                table(
                    ['ID', 'Datum', 'Kontakt', 'Orignalbetrag', 'Betrag', 'Referenz'],
                    [
                        [
                            $receipt->payable[0]->transaction->id,
                            $receipt->payable[0]->transaction->booked_on->format('d.m.Y'),
                            $receipt->payable[0]->transaction->amount,
                            $receipt->payable[0]->transaction->purpose,
                        ],
                    ],
                );

                $selectOptions[$receipt->payable[0]->id] = $receipt->payable[0]->transaction->booked_on->format('d.m.Y');
                $selectOptions[0] = 'keine';

                $answer = select(
                    label: 'Zahlung zuordnen',
                    options: $selectOptions,
                    scroll: 10,
                );

                $id = intval($answer);

                if ($id !== 0) {
                    PaymentService::adjustPaymentForReciept($id, 'payment');
                }

            }

            $payments = PaymentService::getPaymentsForReceipt($receipt);

            if ($payments && $payments->count() > 0) {

                if (! in_array($receipt->contact_id, $this->ignoredContacts)) {

                    $paymentsWithTransactions = $payments->map(function ($payment) {
                        $transaction = $payment->transaction->toArray();
                        $transaction['rank'] = $payment->rank;
                        $transaction['id'] = $payment->id;
                        $transaction['booked_on'] = $payment->transaction->booked_on->format('d.m.Y');
                        $transaction['contact'] = $payment->transaction->contact_id ? $payment->transaction->contact->name : $payment->transaction->name;

                        return $transaction;
                    });

                    table(
                        headers: ['ID', 'Datum', 'Kontakt', 'Verwendungszweck', 'Betrag', 'Rank'],
                        rows: $paymentsWithTransactions->select('id', 'booked_on', 'contact', 'bookkepping_text', 'amount',
                            'rank')
                    );

                    $selectOptions = $paymentsWithTransactions->pluck('booked_on', 'id');
                    $selectOptions[0] = 'keine';
                    $selectOptions[-1] = 'ignorieren';

                    $answer = select(
                        label: 'Zahlung zuordnen',
                        options: $selectOptions,
                        scroll: 10,
                    );

                    $id = intval($answer);
                    dump($id);

                    if ($id === -1) {
                        $this->ignoredContacts[] = $receipt->contact_id;
                        dump($this->ignoredContacts);
                    }

                    if ($id > 0) {
                        PaymentService::adjustPaymentForReciept($id);
                    }

                } else {
                    warning('Ignoriert');
                }
            } else {
                warning('Keine zugehörigen Transaktionen gefunden.');
                $selectOptions[0] = 'keine';
                $selectOptions[-1] = 'ignorieren';
                $selectOptions[-2] = 'suchen';

                $answer = select(
                    label: 'Zahlung zuordnen',
                    options: $selectOptions,
                    scroll: 10,
                );

                $answerId = intval($answer);

                if ($answerId === -1) {
                    $this->ignoredContacts[] = $receipt->contact_id;
                }

                if ($answer === -2) {

                    $id = search(
                        label: 'Search for the user that should receive the mail',
                        options: fn (string $value) => strlen($value) > 0
                            ? Transaction::whereLike('name', "%{$value}%")->orWhereLike('purpose', "%{$value}%")->pluck('name', 'id')->all()
                            : [],
                    );
                    if ($id) {
                        $transaction = Transaction::find($id);
                        $payment = new Payment;

                        $payment->transaction_id = $transaction->id;
                        $payment->amount = $transaction->amount;
                        $payment->issued_on = $transaction->booked_on;
                        $payment->payable()->associate($receipt);
                        $payment->is_confirmed = true;
                        $payment->save();

                        PaymentService::checkForCurrencyDifference($receipt, $payment);

                    }
                }
            }
        });
        $receipts = Receipt::whereIn('contact_id', $this->ignoredContacts);
        $receipts->each(function (Receipt $receipt) {
            $payment = new Payment;
            $payment->amount = $receipt->amount;
            $payment->transaction_id = 0;
            $payment->is_ignored = 1;
            $payment->is_confirmed = 1;
            $payment->issued_on = $receipt->issued_on;
            $payment->payable()->associate($receipt);
            $payment->save();
        });

    }
}
