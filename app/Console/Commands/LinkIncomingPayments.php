<?php

namespace App\Console\Commands;

use App\Models\PaymentSuggestion;
use App\Models\Receipt;
use App\Models\Transaction;
use Illuminate\Console\Command;

use function Laravel\Prompts\Table;

class LinkIncomingPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:link-incoming-payments';

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
        $receipts = Receipt::query()->with('contact')->orderBy('issued_on')->get();
        $receipts->each(function ($receipt) {
            $contactTransactions = Transaction::query()
                ->with('contact')
                ->where('contact_id', $receipt->contact_id)
                ->where('purpose', 'like', "%{$receipt->reference}%")
                ->first();

            if ($contactTransactions) {
                PaymentSuggestion::create([
                    'receipt_id' => $receipt->id,
                    'transaction_id' => $contactTransactions->id,
                    'confidence' => 100,
                ]);
            }

            if ($contactTransactions === null) {
                $startDate = $receipt->issued_on->subDays(14);
                $endDate = $receipt->issued_on->addDays(14);

                $contactTransactions = Transaction::query()
                    ->with('contact')
                    ->where('contact_id', $receipt->contact_id)
                    ->where('amount', $receipt->amount)
                    ->whereBetween('booked_on', [$startDate, $endDate])
                    ->orderBy('booked_on')
                    ->first();

                if ($contactTransactions) {
                    PaymentSuggestion::create([
                        'receipt_id' => $receipt->id,
                        'transaction_id' => $contactTransactions->id,
                        'confidence' => 80,
                    ]);
                }

                if ($contactTransactions) {
                    table(
                        ['Datum', 'Kontakt', 'Betrag', 'Reference', 'MD5', 'RR'],
                        [
                            [
                                $receipt->issued_on->format('d.m.Y'),
                                $receipt->contact->name,
                                $receipt->reference,
                                $receipt->amount,
                            ],
                            [
                                $contactTransactions->booked_on->format('d.m.Y'),
                                $contactTransactions->contact->name,
                                $contactTransactions->purpose,
                                $contactTransactions->amount,
                            ],
                        ]);
                }
            }
        });
    }
}
