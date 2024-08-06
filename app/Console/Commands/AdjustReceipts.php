<?php

namespace App\Console\Commands;

use App\Models\PaymentSuggestion;
use App\Models\Receipt;
use App\Services\PaymentService;
use Illuminate\Console\Command;

use function Laravel\Prompts\table;
use function Laravel\Prompts\text;
use function Laravel\Prompts\warning;

class AdjustReceipts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:adjust-receipts {receipt?}';

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
        PaymentSuggestion::truncate();
        if ($this->argument('receipt')) {
            $receipts = Receipt::with('contact')->where('id', $this->argument('receipt'))->get();
        } else {
            $receipts = Receipt::with('contact')->orderBy('issued_on')->get();
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

            $receipt->load('payments')->load('payments.transaction');

            if ($receipt->payments && $receipt->payments->count() && $receipt->payments[0]->is_confirmed) {
                table(
                    ['ID', 'Datum', 'Kontakt', 'Orignalbetrag', 'Betrag', 'Referenz'],
                    [
                        [
                            $receipt->payments[0]->transaction->id,
                            $receipt->payments[0]->transaction->booked_on->format('d.m.Y'),
                            $receipt->payments[0]->transaction->purpose,
                        ],
                    ],
                );

                return true;
            }

            $payments = PaymentService::getPaymentsForReceipt($receipt);
            if ($payments && $payments->count() > 0) {
                $paymentsWithTransactions = $payments->map(function ($payment) {
                    dump($payment->transaction);
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

                $answer = text('ID?', default: $payments[0]->id);
                $id = intval($answer);

                if ($id === 0) {
                    dump($id);
                } else {
                    PaymentService::adjustPaymentForReciept($id);
                }

            } else {
                warning('Keine zugehörigen Transaktionen gefunden.');
            }
        });
    }
}
