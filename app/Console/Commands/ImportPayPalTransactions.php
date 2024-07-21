<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Throwable;
use App\Models\PayPalTransactions;

class ImportPayPalTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-pay-pal-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @throws Throwable
     */
    public function handle()
    {
        $provider = new PayPalClient;
        $provider->getAccessToken();

        /*
         *   "start_date" => "2024-07-15T17:37:24+02:00"
         *  "end_date" => "2024-08-14T17:37:24+02:00"
         */

        $filters = [
            'start_date' => '2024-06-01T17:37:24%2b02:00',
            'end_date' => '2024-06-28T17:37:24%2b02:00',
        ];

        $response = $provider->listTransactions($filters, 'all');

        $transactions = collect($response['transaction_details']);
        $transactions->values()->each(function ($item) {
            $transaction = collect($item)->dot();

            $payPalTransaction = new PayPalTransactions();
            $payPalTransaction->transaction_updated_date = $transaction->get('transaction_info.transaction_initiation_date');
            $payPalTransaction->transaction_initiation_date = $transaction->get('transaction_info.transaction_updated_date');

            $payPalTransaction->transaction_id = $transaction->get('transaction_info.transaction_id');
            $payPalTransaction->paypal_reference_id = $transaction->get('transaction_info.paypal_reference_id', '');
            $payPalTransaction->paypal_reference_id_type = $transaction->get('transaction_info.paypal_reference_id_type',
                '');
            $payPalTransaction->transaction_event_code = $transaction->get('transaction_info.transaction_event_code');
            $payPalTransaction->transaction_status = $transaction->get('transaction_info.transaction_status');
            $payPalTransaction->transaction_currency = $transaction->get('transaction_info.transaction_amount.currency_code');
            $payPalTransaction->transaction_amount = $transaction->get('transaction_info.transaction_amount.value');

            $payPalTransaction->transaction_subject = $transaction->get('transaction_info.transaction_subject', '');

            $payPalTransaction->payer_email = $transaction->get('payer_info.email_address', '');
            $payPalTransaction->payer_name = $transaction->get('payer_info.payer_name.alternate_full_name', '');
            $payPalTransaction->data = json_encode($transaction->toArray());
            $payPalTransaction->save();
        });

        // $jsonInvoices = Storage::disk('private')->put('paypal.json', json_encode($response));

    }
}
