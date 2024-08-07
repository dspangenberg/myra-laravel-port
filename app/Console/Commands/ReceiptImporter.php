<?php

namespace App\Console\Commands;

use App\Models\BookkeepingBooking;
use App\Models\Payment;
use App\Models\Receipt;
use App\Models\Transaction;
use Illuminate\Console\Command;

use function Laravel\Prompts\table;

class ReceiptImporter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:receipt-importer';

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
        // $bookings = Transaction::doesntHave('booking')->get()->pluck('id');
        // $receipts = Receipt::doesntHave('booking')->get()->pluck('id');

        $transactionIds = Payment::get()->pluck('transaction_id')->toArray();
        $transactions = Transaction::whereNotIn('id', $transactionIds)
            ->where('contact_id', 0)
            ->where('is_private', 0)
            ->where('is_transit', 0)
            ->whereNotIn('booking_text', ['Currency conversion', 'Cash back bonus'])
            ->get();

        table(
            headers: ['ID', 'Datum', 'Name', 'Verwendungszweck', 'Betrag'],
            rows: $transactions->select('id', 'booked_on', 'name', 'purpose', 'amount')
        );

        var_dump($transactions->count());
        $bookings = BookkeepingBooking::where('account_id_debit', 2150)->get()->pluck('id')->toArray();
        $bookingIds = implode(',', $bookings);
        var_dump($bookingIds);

    }
}
